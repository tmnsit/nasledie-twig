import $ from 'cash-dom';
import ajax from '@fdaciuk/ajax';
import {serialize, serializeArray} from './_serialize';


window.jQuery = window.$ = $;
window.ajax = ajax;


// TODO реализовать замену jQuery.ajax через axios
$.ajax = (params) => {
    let onSuccess;

    // jQuery может принимать в качестве входных данных
    // как массив объектов, так и просто объект
    // Массив необходимо конвертировтаь в объект
    if (
        params.hasOwnProperty('data') &&
        params.data &&
        Array.isArray(params.data)
    ) {
        let dataObject = {};
        params.data.forEach((dataItem) => {
            if (
                dataItem &&
                dataItem.hasOwnProperty('name') && dataItem.name &&
                dataItem.hasOwnProperty('value') && dataItem.value
            ) {
                dataObject[dataItem.name] = dataItem.value;
            }
        });
        params.data = dataObject;
    }

    params.method = (params.method || 'get').toLowerCase();

    params.headers = {
        'X-Requested-With': 'XMLHttpRequest',
        ...(params.headers || {}),
    };

    if (params.success) {
        onSuccess = params.success;
        delete params.success;
    }

    const request = ajax(params);

    if (typeof onSuccess === 'function') {
        request.then((response) => {
            onSuccess(response);
        });
    }

    return request;
};


$.fn.extend({
    serialize: function () {
        console.log('serialize', this);
        if (this && this.length) {
            return serialize(this[0]);
        } else {
            return '';
        }
    },
    serializeArray: function () {
        console.log('serializeArray', this);
        if (this && this.length) {
            return serializeArray(this[0]);
        } else {
            return [];
        }
    }
});


const hashDataArray = (data) => {
    let result = {};
    if (data && data.length) {
        data.forEach((item) => {
            if (item.name) {
                result[item.name] = item.value;
            }
        });
    }

    return result;
};
