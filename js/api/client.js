/**
 * LICENSE: This source file is subject to version 3.0 of the GPL license
 * that is available through the world-wide-web at the following URI:
 * https://www.gnu.org/licenses/gpl-3.0.fr.html (french version).
 *
 * @author      Guillaume Gagnaire <contact@42php.com>
 * @link        https://www.github.com/42php/42php
 * @license     https://www.gnu.org/licenses/gpl-3.0.fr.html GPL
 */

(function(w) {

    var promise = function(xhr, callback) {
        this.done = false;
        this.xhr = xhr;
        var _this = this;

        this.abort = function(){
            if (this.done)
                return;
            this.xhr.abort();
            this.done = true;
            callListeners('abort', client);
        };

        this.xhr.onreadystatechange = function(){
            if (_this.xhr.readyState == 4) {
                _this.done = true;
                callback(_this.xhr.status);
            }
        };
    };

    var basePath = '/api';
    var token = '';
    var lang = 'fr-FR';

    var throwError = function(code, message) {
        console.log('[API][' + code + '] ' + message);
        callListeners('error', code, message);
    };

    var listeners = {
        error: [],
        loading: [],
        loaded: [],
        abort: []
    };

    var callListeners = function(type, param1, param2, param3) {
        if (!listeners.hasOwnProperty(type))
            return false;
        for (var i = 0; i < listeners[type].length; i++) {
            listeners[type][i](param1, param2, param3);
        }
        return true;
    };

    var client = {};

    client.setLang = function(l) {
        lang = l;
    };

    client.setToken = function(t) {
        token = t;
    };

    client.call = function(method, path, parameters, callbacks) {
        if (!parameters)
            parameters = {};

        if (typeof callbacks != "object")
            callbacks = {
                any: callbacks
            };

        if (path.substr(0, 1) != '/')
            path = '/' + path;

        callListeners('loading', client);

        var xmlhttp;
        if (window.XMLHttpRequest)
            xmlhttp = new XMLHttpRequest();
        else
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");

        xmlhttp.open(method, basePath + path, true);
        xmlhttp.setRequestHeader("Content-Type", "application/json");
        xmlhttp.setRequestHeader("Accept", "application/json");
        xmlhttp.setRequestHeader("X-Token", token);
        xmlhttp.setRequestHeader("X-Lang", lang);
        xmlhttp.send(JSON.stringify(parameters));

        var p = null;
        (function(xmlhttp){
            p = new promise(xmlhttp, function(code) {
                callListeners('loaded', client);

                var ret = JSON.parse(xmlhttp.responseText);

                if (ret.error && ret.error_message) {
                    throwError(ret.error, ret.error_message);
                }

                var t = xmlhttp.getResponseHeader('X-Token');
                if (t)
                    client.setToken(t);

                if (callbacks.hasOwnProperty(code)) {
                    callbacks[code](ret);
                } else if (callbacks.hasOwnProperty('any')) {
                    callbacks.any(ret);
                }
            });
        })(xmlhttp);
        return p;
    };

    client.get = function(path, parameters, callbacks) {
        client.call('GET', path, parameters, callbacks);
    };

    client.post = function(path, parameters, callbacks) {
        client.call('POST', path, parameters, callbacks);
    };

    client.put = function(path, parameters, callbacks) {
        client.call('PUT', path, parameters, callbacks);
    };

    client.patch = function(path, parameters, callbacks) {
        client.call('PATCH', path, parameters, callbacks);
    };

    client['delete'] = function(path, callbacks) {
        client.call('DELETE', path, {}, callbacks);
    };

    client.on = function(type, callback) {
        if (!listeners.hasOwnProperty(type))
            return false;
        listeners[type].push(callback);
        return true;
    };

    w.api = client;
})(window);