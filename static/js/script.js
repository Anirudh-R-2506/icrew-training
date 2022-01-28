function inViewport (el) {

    var r, html;
    if ( !el || 1 !== el.nodeType ) { return false; }
    html = document.documentElement;
    r = el.getBoundingClientRect();

    return ( !!r
      && r.bottom >= 0
      && r.right >= 0
      && r.top <= html.clientHeight
      && r.left <= html.clientWidth
    );

}

const elements = document.querySelectorAll('.anim');
observer = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
        if(entry.intersectionRatio > 0 && !entry.target.dataset.done) {            
            entry.target.style = `animation: ${entry.target.dataset.type} 0.7s ${entry.target.dataset.delay} forwards ease-in-out;`;
            entry.target.dataset.done = true;            
        }        
    })
});
elements.forEach(element => {
    observer.observe(element)
});

