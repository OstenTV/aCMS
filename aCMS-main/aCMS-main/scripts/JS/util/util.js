(function (a, b, c) { if (c in b && b[c]) { var d, e = a.location, f = /^(a|html)$/i; a.addEventListener("click", function (a) { d = a.target; while (!f.test(d.nodeName)) d = d.parentNode; "href" in d && (d.href.indexOf("http") || ~d.href.indexOf(e.host)) && (a.preventDefault(), e.href = d.href) }, !1) } })(document, window.navigator, "standalone")


function getParameterByName(name, url) {
    if (!url) url = window.location.href;
    name = name.replace(/[\[\]]/g, "\\$&");
    var regex = new RegExp("[?&]" + name + "(=([^&#]*)|&|#|$)"),
        results = regex.exec(url);
    if (!results) return null;
    if (!results[2]) return '';
    return decodeURIComponent(results[2].replace(/\+/g, " "));
}

function css(selector, property, value) {
    for (var i = 0; i < document.styleSheets.length; i++) {//Loop through all styles
        try {
        document.styleSheets[i].insertRule(selector + ' {' + property + ':' + value + '}', document.styleSheets[i].cssRules.length);
        } catch (err) { try { document.styleSheets[i].addRule(selector, property + ':' + value); } catch (err) { } }//IE
    }
}

$(document).ready(function () {

    if (window.location.href.indexOf('#LogInModal') != -1) {
        $('#LogInModal').modal('show');
    }

    if (window.location.href.indexOf('#RegisterModal') != -1) {
        $('#RegisterModal').modal('show');
    }

    if (window.location.href.indexOf('#ForgotPasswordModal') != -1) {
        $('#ForgotPasswordModal').modal('show');
    }

});