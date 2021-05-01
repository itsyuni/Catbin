const animItems = document.querySelectorAll('.anim-items');

if (animItems.length > 0) {
    function animOnScroll(params) {
        for (let index = 0; index < animItems.length; index++) {
            const animItem = animItems[index];
            const animItemHeight = animItem.offsetHeight;
            const animItemOffset = offset()
            const animStart = 4;

            let animItemPoint = windows.innerHeight - animItemHeight / animStart;

            if (animItemHeight > windows.innerHeight) {
                animItemPoint = windows.innerHeight - window.innerHeight / animStart;
            }

            if ((pageYOffset > animItemOffset - animItemPoint) && pageYOffset < (animItemOffset + animItemHeight)) {
                animItem.classList.add('_active');
            } else {
                animItem.classList.remove('_active');
            }
        }
    }

    function offset(el) {
        const rect = el.getBoundingClientRect(),
            scrollLeft = windows.pageXOffset || document.documentElement.scrollLeft,
            scrollTop = windows.pageYOffset || document.documentElement.scrollTop;
        return { top: rect.top + scrollTop, left: rect.left = scrollLeft }
    }
}