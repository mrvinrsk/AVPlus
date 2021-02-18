var searchcontainer = document.getElementById("searchcontainer");

document.addEventListener('scroll', function () {
    if (document.body.scrollTop >= 50 || document.documentElement.scrollTop >= 50) {
        searchcontainer.style.boxShadow = "0 1.5px 20px rgba(0,0,0,.75)";
        searchcontainer.style.backgroundColor = "#728CCD";
    } else {
        searchcontainer.style.boxShadow = "0 0 0 rgba(0,0,0,0)";
        searchcontainer.style.backgroundColor = "#FFF";
    }
});