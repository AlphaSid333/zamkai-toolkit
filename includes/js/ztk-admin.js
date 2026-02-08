{
    const toggle = document.getElementById("debug_check");
    const target = document.getElementById("zk-debug-display");

    function updateVisibility(){
        if (toggle.checked){
            target.style.display = "flex";
        }
        else{
            target.style.display = "none";
        }
    }
    updateVisibility();

    toggle.addEventListener('change',updateVisibility);
}