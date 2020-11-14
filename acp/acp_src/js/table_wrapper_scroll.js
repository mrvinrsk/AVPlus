document.addEventListener('scroll', function () {
    if (document.body.scrollTop >= 50 || document.documentElement.scrollTop >= 50) {
        document.getElementById("searchcontainer").style.boxShadow = "0 0 15px rgba(0,0,0,.15)";
        document.getElementById("searchcontainer").style.borderBottom = "1px solid #888888";
    } else {
        document.getElementById("searchcontainer").style.boxShadow = "0 0 0 rgba(0,0,0,0)";
        document.getElementById("searchcontainer").style.borderBottom = "1px solid transparent";
    }
});