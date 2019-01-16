function css(selector, property, value) {
    for (var i=0; i<document.styleSheets.length;i++) {//Loop through all styles
        try { document.styleSheets[i].insertRule(selector+ ' {'+property+':'+value+'}', document.styleSheets[i].cssRules.length);
        } catch(err) {try { document.styleSheets[i].addRule(selector, property+':'+value);} catch(err) {}}//IE
    }
}

function menu_fade_in() {
	css('.navmain', 'display', 'inline-block')
	css('.menutint', 'display', 'inline-block')
	css('.menubutton_close', 'display', 'inline-block')
}
function menu_fade_out() {
	css('.navmain', 'display', 'none')
	css('.menutint', 'display', 'none')
	css('.menubutton_close', 'display', 'none')
}