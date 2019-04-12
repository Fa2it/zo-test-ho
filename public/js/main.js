function openNav() {
    document.getElementById("mySidebar").style.width = "200px";
    document.getElementById("main").style.marginLeft = "-215px";
}

function closeNav() {
    document.getElementById("mySidebar").style.width = "0";
    document.getElementById("main").style.marginLeft= "-15px";
}

window.addEventListener("resize", checkdeviceWidth );
function checkdeviceWidth(){
    var width = (window.innerWidth > 0) ? window.innerWidth : screen.width;
    if( width < 576 ){
        document.getElementById("sidebarToggleTop").style.display="block";
        document.getElementById("mySidebar").style.width = "0";
        document.getElementById("main").style.marginLeft= "-15px";
    } else {
        document.getElementById("sidebarToggleTop").style.display="none";
    }

}

setdeviceWidth();

function setdeviceWidth(){
    var width = (window.innerWidth > 0) ? window.innerWidth : screen.width;
    if( width < 576 ){
        document.getElementById("sidebarToggleTop").style.display="block";
        document.getElementById("mySidebar").style.width = "0";
        document.getElementById("main").style.marginLeft= "-15px";
    } else {
        document.getElementById("sidebarToggleTop").style.display="none";
    }

}