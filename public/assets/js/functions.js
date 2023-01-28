const baseUrl = window.location.origin;

function url (slug = '') {
    return baseUrl + '/' + slug;
}

//===================================================================

function ready (fn) {
    if (document.readyState == 'complete'){
        fn();
    } else {
        document.addEventListener('DOMContentLoaded', fn);
    }
}

//===================================================================

function fadeOut (el, fn) {
    el.classList.add('hidden');
    el.classList.remove('shown');

    setTimeout(() => {
        el.classList.add('hardnone');

        // callback after
        if (typeof fn === "function") {
            fn();
        }

    }, 400);
}

//===================================================================

function fadeIn (selector, fn) {
    
    selector.classList.remove('hardnone');
    selector.classList.remove('hidden');
    selector.classList.add('shown');

    // callback after
    setTimeout(function(e){

        // callback after
        if (typeof fn === "function") {
            fn();
        }

    }, 400);
}

//===================================================================

function xhrGET (settings) {

    //-- CALLBACK BEFORE REQUEST --//
    if (typeof settings.before === "function") {
        settings.before();
    }

    var request = new XMLHttpRequest();

    request.open('GET', settings.link, true);

    // set no cache
    request.setRequestHeader('cache-control', 'no-cache, must-revalidate, post-check=0, pre-check=0');
    request.setRequestHeader('cache-control', 'max-age=0');
    request.setRequestHeader('expires', '0');
    request.setRequestHeader('expires', 'Tue, 01 Jan 1980 1:00:00 GMT');
    request.setRequestHeader('pragma', 'no-cache');

    request.onload = function() {
        if (this.status >= 200 && this.status < 400) {

            var data = this.response;

            //-- CALLBACK ON SUCCESS --//
            if (typeof settings.success === "function") {
                settings.success(data);
            }

        } else {

            var data = this.response;

            //-- CALLBACK ON ERROR FROM SERVER --//
            if (typeof settings.catch === "function") {
                settings.catch(data);
            }
        }
    };

    request.onerror = function() {

        //-- CALLBACK ON ERROR CONNECTIVITY --//
        if (typeof settings.error === "function") {
            settings.error();
        }
    };

    // send AJAX
    request.withCredentials = true;
    request.send();

    //-- CALLBACK AFTER REQUEST --//
    if (typeof settings.after === "function") {
        settings.after();
    }
}

//===================================================================

function xhrPOST (settings) {

    //-- CALLBACK BEFORE REQUEST --//
    if (typeof settings.before === "function") {
        settings.before();
    }

    var request = new XMLHttpRequest();

    request.open('POST', settings.link, true);

    // set no cache
    request.setRequestHeader('cache-control', 'no-cache, must-revalidate, post-check=0, pre-check=0');
    request.setRequestHeader('cache-control', 'max-age=0');
    request.setRequestHeader('expires', '0');
    request.setRequestHeader('expires', 'Tue, 01 Jan 1980 1:00:00 GMT');
    request.setRequestHeader('pragma', 'no-cache');

    request.onload = function() {
        if (this.status >= 200 && this.status < 400) {

            var data = this.response;

            //-- CALLBACK ON SUCCESS --//
            if (typeof settings.success === "function") {
                settings.success(data);
            }

        } else {

            var data = this.response;

            //-- CALLBACK ON ERROR FROM SERVER --//
            if (typeof settings.catch === "function") {
                settings.catch(data);
            }
        }
    };

    request.onerror = function() {

        //-- CALLBACK ON ERROR CONNECTIVITY --//
        if (typeof settings.error === "function") {
            settings.error();
        }
    };

    // send AJAX
    request.withCredentials = true;
    request.send(settings.data);

    //-- CALLBACK AFTER REQUEST --//
    if (typeof settings.after === "function") {
        settings.after();
    }
}

//===================================================================