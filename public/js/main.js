var t_state = 0;
function openNav() {
    document.getElementById("rightSidebar").style.width = "200px";
    document.getElementById("mainContent").style.marginLeft = "-230px";
}

function closeNav() {
    document.getElementById("rightSidebar").style.width = "0";
    document.getElementById("mainContent").style.marginLeft= "-30px";
}

function displayMyMenu(){
    if( t_state == 0 ){
        t_state = 1;
        document.getElementById("sidebarToggleTop").innerHTML = '<i class="far fa-window-close"></i>';
        openNav();
    } else {
        document.getElementById("sidebarToggleTop").innerHTML = '<i class="fa fa-bars"></i>';
        t_state = 0;
        closeNav();
    }
}

document.getElementById("sidebarToggleTop").addEventListener("click", displayMyMenu);

window.addEventListener("resize", checkdeviceWidth );
function checkdeviceWidth(){
    var width = (window.innerWidth > 0) ? window.innerWidth : screen.width;
    if( width < 576 ){
        document.getElementById("sidebarToggleTop").style.display="block";
        document.getElementById("rightSidebar").style.width = "0";
        document.getElementById("mainContent").style.marginLeft= "-30px";
    } else {
        document.getElementById("sidebarToggleTop").style.display="none";
    }

}

setdeviceWidth();

function setdeviceWidth(){
    var width = (window.innerWidth > 0) ? window.innerWidth : screen.width;
    if( width < 576 ){
        document.getElementById("sidebarToggleTop").style.display="block";
        document.getElementById("rightSidebar").style.width = "0";
        document.getElementById("mainContent").style.marginLeft= "-30px";
    } else {
        document.getElementById("sidebarToggleTop").style.display="none";
    }

}