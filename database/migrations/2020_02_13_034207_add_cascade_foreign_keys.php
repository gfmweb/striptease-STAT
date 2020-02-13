<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddCascadeForeignKeys extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 * @throws Throwable
	 */
	public function up()
	{
		// Меняем MyISAM на InnoDB (Оказалось ларка по дефолту генерит MyISAM) И приводим кодировку в единый вид
		$tables = [
			'bvstat_channels',
			'bvstat_channels_groups',
			'bvstat_cities',
			'bvstat_migrations',
			'bvstat_projects',
			'bvstat_statuses',
			'bvstat_statuses_history',
			'bvstat_sub_project_tag',
			'bvstat_sub_projects',
			'bvstat_tags',
			'bvstat_user_sub_projects',
			'bvstat_user_target_data',
			'bvstat_user_targets',
			'bvstat_users',
		];
		foreach ($tables as $table) {
			DB::statement('ALTER TABLE ' . $table . ' ENGINE = InnoDB');
			DB::statement('ALTER TABLE ' . $table . ' CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci');
		}

		// В одной транзакции (хоть некоторые параметры меняются и вне транзакции)
		DB::transaction(function () {
			// Правим столбцы делаем им unsigned и ставим туже разрядность(важно для внешнего ключа)
			Schema::table('sub_projects', function (Blueprint $table) {
				$table->integer('city_id')->nullable(false)->unsigned()->change();
			});
			// Удаляем уже созданные внешние связи если были (костыльно но иного варианта ларка не предлагает)
			Schema::table('sub_projects', function (Blueprint $table) {
				$foreignKeys = $this->listTableForeignKeys('bvstat_sub_projects');

				if (in_array('sub_projects_project_id_foreign', $foreignKeys))
					$table->dropForeign('sub_projects_project_id_foreign');
				if (in_array('sub_projects_city_id_foreign', $foreignKeys))
					$table->dropForeign('sub_projects_city_id_foreign');
			});
			// Добавляем внешние связи
			Schema::table('sub_projects', function (Blueprint $table) {
				// При удалении проекта удалять и подпроект
				$table->foreign('project_id')
					->references('id')->on('projects')
					->onDelete('cascade')
					->onUpdate('cascade');

				// При удалении города запретить удалять если есть подпроекты с таким городом
				$table->foreign('city_id')
					->references('id')->on('cities')
					->onDelete('RESTRICT')
					->onUpdate('cascade');
			});


			// Правим столбцы делаем им unsigned и ставим туже разрядность(важно для внешнего ключа)
			DB::statement('
				ALTER TABLE `matikbeta_virgin`.`bvstat_user_sub_projects` 
				MODIFY COLUMN `id` int(8) UNSIGNED NOT NULL AUTO_INCREMENT FIRST;');

			Schema::table('user_sub_projects', function (Blueprint $table) {
				$table->bigInteger('sub_project_id')->nullable(false)->unsigned()->change();
				$table->integer('user_id')->nullable(false)->unsigned()->change();
			});
			// Удаляем уже созданные внешние связи если были (костыльно но иного варианта ларка не предлагает)
			Schema::table('user_sub_projects', function (Blueprint $table) {
				$foreignKeys = $this->listTableForeignKeys('bvstat_user_sub_projects');

				if (in_array('user_sub_projects_sub_project_id_foreign', $foreignKeys))
					$table->dropForeign('user_sub_projects_sub_project_id_foreign');
				if (in_array('user_sub_projects_user_id_foreign', $foreignKeys))
					$table->dropForeign('user_sub_projects_user_id_foreign');
			});
			// Добавляем внешние связи
			Schema::table('user_sub_projects', function (Blueprint $table) {
				// При удалении подпроекта удалять и связь пользователь-подпроект
				$table->foreign('sub_project_id')
					->references('id')->on('sub_projects')
					->onDelete('cascade')
					->onUpdate('cascade');
				// При удалении пользователя удалять и связь пользователь-подпроект
				$table->foreign('user_id')
					->references('id')->on('users')
					->onDelete('cascade')
					->onUpdate('cascade');
			});

			// Правим столбцы делаем им unsigned и ставим туже разрядность(важно для внешнего ключа)
			DB::statement('
				ALTER TABLE `bvstat_user_targets` 
					MODIFY COLUMN `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT FIRST,
					MODIFY COLUMN `user_sub_project_id` int(8) UNSIGNED NOT NULL AFTER `id`,
					MODIFY COLUMN `channel_id` int(8) UNSIGNED NOT NULL AFTER `user_sub_project_id`,
					MODIFY COLUMN `status_id` int(3) UNSIGNED NOT NULL DEFAULT 1 AFTER `channel_id`;
			');
			DB::statement('
				ALTER TABLE `bvstat_statuses` 
					MODIFY COLUMN `id` int(3) UNSIGNED NOT NULL AUTO_INCREMENT FIRST;
			');

			// Удаляем уже созданные внешние связи если были (костыльно но иного варианта ларка не предлагает)
			Schema::table('user_targets', function (Blueprint $table) {
				$foreignKeys = $this->listTableForeignKeys('bvstat_user_targets');

				if (in_array('user_targets_user_sub_project_id_foreign', $foreignKeys))
					$table->dropForeign('user_targets_user_sub_project_id_foreign');
				if (in_array('user_targets_channel_id_foreign', $foreignKeys))
					$table->dropForeign('user_targets_channel_id_foreign');
				if (in_array('user_targets_status_id_foreign', $foreignKeys))
					$table->dropForeign('user_targets_status_id_foreign');
			});
			// Добавляем внешние связи
			Schema::table('user_targets', function (Blueprint $table) {
				// При удалении связи пользователь-подпроект удалять и цель(target)
				$table->foreign('user_sub_project_id')
					->references('id')->on('user_sub_projects')
					->onDelete('cascade')
					->onUpdate('cascade');
				// При удалении канала удалять и цель(target)
				$table->foreign('channel_id')
					->references('id')->on('channels')
					->onDelete('cascade')
					->onUpdate('cascade');
				// При удалении статуса запрещать удаление(статуса) пока у цели(target) есть связи с таким статусом
				$table->foreign('status_id')
					->references('id')->on('statuses')
					->onDelete('RESTRICT')
					->onUpdate('cascade');
			});

			// Правим столбцы делаем им unsigned и ставим туже разрядность(важно для внешнего ключа)
			Schema::table('user_target_data', function (Blueprint $table) {
				$table->integer('user_target_id')->unsigned()->nullable(false)->change();
			});
			// Удаляем уже созданные внешние связи если были (костыльно но иного варианта ларка не предлагает)
			Schema::table('user_target_data', function (Blueprint $table) {
				$foreignKeys = $this->listTableForeignKeys('bvstat_user_target_data');

				if (in_array('user_target_data_user_target_id_foreign', $foreignKeys))
					$table->dropForeign('user_target_data_user_target_id_foreign');
			});
			// Добавляем внешние связи
			Schema::table('user_target_data', function (Blueprint $table) {
				// При удалении цели(target) зудалять и все данные по ней
				$table->foreign('user_target_id')
					->references('id')->on('user_targets')
					->onDelete('cascade')
					->onUpdate('cascade');
			});

			// Правим столбцы делаем им unsigned и ставим туже разрядность(важно для внешнего ключа)
			Schema::table('channels', function (Blueprint $table) {
				$table->integer('group_id')->unsigned()->nullable(true)->change();
			});
			// Удаляем уже созданные внешние связи если были (костыльно но иного варианта ларка не предлагает)
			Schema::table('channels', function (Blueprint $table) {
				$foreignKeys = $this->listTableForeignKeys('bvstat_channels');

				if (in_array('channels_group_id_foreign', $foreignKeys))
					$table->dropForeign('channels_group_id_foreign');
			});
			// Добавляем внешние связи
			Schema::table('channels', function (Blueprint $table) {
				// При удалении группы каналов ставить NULL в поле (не привязан к группе)
				$table->foreign('group_id')
					->references('id')->on('channels_groups')
					->onDelete('SET NULL')
					->onUpdate('cascade');
			});

			// Правим столбцы делаем им unsigned и ставим туже разрядность(важно для внешнего ключа)
			Schema::table('sub_project_tag', function (Blueprint $table) {
				$table->bigInteger('sub_project_id')->unsigned()->nullable(false)->change();
				$table->integer('tag_id')->unsigned()->nullable(false)->change();
			});
			// Удаляем уже созданные внешние связи если были (костыльно но иного варианта ларка не предлагает)
			Schema::table('sub_project_tag', function (Blueprint $table) {
				$foreignKeys = $this->listTableForeignKeys('bvstat_sub_project_tag');

				if (in_array('sub_project_tag_sub_project_id_foreign', $foreignKeys))
					$table->dropForeign('sub_projects_tag_sub_project_id_foreign');
				if (in_array('sub_project_tag_tag_id_foreign', $foreignKeys))
					$table->dropForeign('sub_projects_tag_tag_id_foreign');
			});
			// Добавляем внешние связи
			Schema::table('sub_project_tag', function (Blueprint $table) {
				// При удалении подпроекта удалять и связь подпроект-тег(многие-ко-многим) с тегом
				$table->foreign('sub_project_id')
					->references('id')->on('sub_projects')
					->onDelete('cascade')
					->onUpdate('cascade');

				// При удалении тега удалять и связь подпроект-тег(многие-ко-многим) с подпроектом
				$table->foreign('tag_id')
					->references('id')->on('tags')
					->onDelete('cascade')
					->onUpdate('cascade');
			});

		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 * @throws Throwable
	 */
	public function down()
	{
		DB::transaction(function () {
			// Подпроекты зависят от Проектов
			Schema::table('sub_projects', function (Blueprint $table) {
				$table->dropForeign('sub_projects_project_id_foreign');
				$table->dropForeign('sub_projects_city_id_foreign');
			});

			// Связка Пользователь-Подпроект зависит от подПроектов
			// Связка Пользователь-Подпроект зависит от Пользователей
			Schema::table('user_sub_projects', function (Blueprint $table) {
				$table->dropForeign('user_sub_projects_sub_project_id_foreign');
				$table->dropForeign('user_sub_projects_user_id_foreign');
			});

			Schema::table('user_targets', function (Blueprint $table) {
				$table->dropForeign('user_targets_user_sub_project_id_foreign');
				$table->dropForeign('user_targets_channel_id_foreign');
				$table->dropForeign('user_targets_status_id_foreign');
			});

			Schema::table('user_targets_data', function (Blueprint $table) {
				$table->dropForeign('user_targets_data_user_target_id_foreign');
			});

			Schema::table('channels', function (Blueprint $table) {
				$table->dropForeign('channels_group_id_foreign');
			});

			Schema::table('sub_projects_tag', function (Blueprint $table) {
				$table->dropForeign('sub_projects_tag_sub_project_id_foreign');
				$table->dropForeign('sub_projects_tag_tag_id_foreign');
			});

		});
	}

	public function listTableForeignKeys($table)
	{
		$conn = Schema::getConnection()->getDoctrineSchemaManager();

		return array_map(function ($key) {
			return $key->getName();
		}, $conn->listTableForeignKeys($table));
	}
}
