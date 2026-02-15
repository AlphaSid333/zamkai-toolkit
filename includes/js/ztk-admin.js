{
    const toggle = document.getElementById("debug_check");
    const target = document.getElementById("zk-debug-display");
    const target2 = document.getElementById("ztk-log-preview");

    function updateVisibility(){
        if (toggle.checked){
            target.style.display = "flex";
            target2.style.display = "block";
        }
        else{
            target.style.display = "none";
            target2.style.display = "none";
        }
    }
    updateVisibility();
    toggle.addEventListener('change',updateVisibility);
}