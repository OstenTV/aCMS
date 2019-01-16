if ((getParameterByName('view') == null || getParameterByName('view') == '') && location.pathname == '/') {
    var active = document.getElementById("nav-button-home");
} else {
    var active = document.getElementById("nav-button-" + getParameterByName("view").split("/", 1));
}

if (active !== null) {
    console.log("Active page is: " + getParameterByName("view"));
    active.classList.add("active");
} else {
    console.warn("Active page is not included in the navbar.")
}