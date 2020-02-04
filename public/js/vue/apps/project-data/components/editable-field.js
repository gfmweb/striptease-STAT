Vue.component('editable-field', {
	props: ['value', 'def'],
	data: function () {
		return {
			newValue: 0,
			invalid: false
		}
	},
	mounted: function () {
		this.newValue = this.value;
	},
	watch: {
		value: function (val) {
			this.newValue = val;
		},
		newValue: function (val) {
			val = String(val).replace(/[^0-9.]|^0*([^0.])/g, '$1');
			if (!val.length) {
				this.invalid  = false;
				this.newValue = this.def || 0;
			} else if (isNaN(val)) {
				this.invalid  = true;
				this.newValue = val;
			} else {
				this.invalid  = false;
				this.newValue = val;
			}
		},
	},
	methods: {
		change() {
			if (this.value != this.newValue && !this.invalid)
				this.$emit('input', this.newValue);
		},
		back() {
			this.newValue = this.value;
		},

	},
	template: `
        <div class="vue-editable-field">
            <div class=" input-append">
                <input type="text" :class="{'input-mini':true, 'bg-danger': invalid}" v-model="newValue" 
                @blur="change()" @focusout="change()" @keyup.enter="change()" @keyup.escape="back()">
            </div>
        </div>`,
});