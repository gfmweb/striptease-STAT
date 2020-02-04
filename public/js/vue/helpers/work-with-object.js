// Создание копии объекта
function newObject(from, to = {}) {
	for (let key in from) {
		if (from[key] instanceof Object) {
			to[key] = from[key] instanceof Array ? newObject(from[key], []) : newObject(from[key]);
		} else {
			to[key] = from[key];
		}
	}
	return to;
}

// Создание пустой копии обхекта
function newEmptyObject(from, to = {}) {
	for (let key in from) {
		if (from[key] instanceof Object) {
			to[key] = from[key] instanceof Array ? [] : newEmptyObject(from[key]);
		} else {
			to[key] = '';
		}
	}
	return to;
}