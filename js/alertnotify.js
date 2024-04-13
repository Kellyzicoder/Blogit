//(a) first, we start (i.e. "call") the autovanish function - otherwise it is just sitting there, but never runs. 
autovanish();
    function autovanish(){
    const avDivs = document.getElementsByClassName('autovanish');
    if (avDivs.length){
       setTimeout(function(){
           avDivs[0].remove();
       }, 3000); //removes the element after 3000ms
    }
    setTimeout(() => {autovanish();}, 500); //re-run every 500ms   
 }