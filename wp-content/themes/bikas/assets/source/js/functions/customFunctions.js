export const toggleCustomClass = (item, customClass) => {
  item.classList.toggle(customClass);
}
// ----------------------------------------------------
export const removeCustomClass = (item, customClass) => {
  item.classList.remove(customClass);
}
// ----------------------------------------------------
export const addCustomClass = (item, customClass) => {
  item.classList.add(customClass);
}
// ----------------------------------------------------
export const removeClassInArray = (arr, customClass) => {
  arr.map((item) => {
    item.classList.remove(customClass);
  });
}
// ----------------------------------------------------
export const addClassInArray = (arr, customClass) => {
  arr.forEach((item) => {
    item.classList.add(customClass);
  });
}
// ----------------------------------------------------
export const toggleClassInArray = (arr, customClass) => {
  arr.map((item) => {
    item.classList.toggle(customClass);
  });
}
//-----------------------------------------------------
export const elementHeight = (el, variableName) => {
  // el -- сам елемент (но не коллекция)
  // variableName -- строка, имя создаваемой переменной
  if(el) {

    let resizeTimer;

    const handleResize = (time = 250) => {
      clearTimeout(resizeTimer);
      resizeTimer = setTimeout(() => {
          const elementHeight = el.offsetHeight;
          document.querySelector(':root').style.setProperty(`--${variableName}`, `${elementHeight}px`);
      }, time);
    };

    window.addEventListener("resize", handleResize);
    window.addEventListener('DOMContentLoaded', handleResize(0))

  }
}

export const elementWidth = (el, variableName) => {
  // el -- сам елемент (но не коллекция)
  // variableName -- строка, имя создаваемой переменной
  if(el) {
    function initListener(){
      const elementWidth = el.offsetWidth;
      document.querySelector(':root').style.setProperty(`--${variableName}`, `${elementWidth}px`);
    }
    window.addEventListener('DOMContentLoaded', initListener)
    window.addEventListener('resize', initListener)
  }
}
