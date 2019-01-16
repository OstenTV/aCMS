console.log("Preloading " + getParameterByName("view"));

var load = document.createElement('form');
load.action = '/?view=' + getParameterByName("view");
load.method = 'post';

var loadinput = document.createElement('input');
loadinput.type = 'hidden';
loadinput.name = 'loaded';
loadinput.value = 1;

load.appendChild(loadinput);
document.getElementById('preloader').appendChild(load);

setTimeout(function () {
    console.log('Submitting form. . .');
    load.submit();
}, 1000);
setTimeout(function () {
    console.log('Loading ' + getParameterByName("view") + 'is taking longer than usual');
    document.getElementById('preloader-unusual_loading_time_text').innerHTML = 'This is taking longer than usual. This might be because some of the servers aren\'t responding. Please keep waiting, thanks.';
}, 10000);

