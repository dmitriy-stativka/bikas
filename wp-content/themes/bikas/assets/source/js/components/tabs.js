import { removeClassInArray,addCustomClass } from "../functions/customFunctions";
import vars from "../_vars";
const {tabsParrents} = vars;
// --------------- tabs custom function --------------- //
function tabsFunction(tabsDataInitArray, tabsNavAttr, tabsContentAttr, active = "active") {
  tabsDataInitArray && tabsDataInitArray.map((tabParent) => {
      if(tabParent) {
        const tabNav = [...tabParent.querySelectorAll(`[${tabsNavAttr}]`)];
        const tabContent = [...tabParent.querySelectorAll(`[${tabsContentAttr}]`)];

        tabNav.map((nav) => {
          nav.addEventListener('click', (e) => {

            e.preventDefault();
            const activeTabAttr = e.target.getAttribute(`${tabsNavAttr}`);
            removeClassInArray(tabNav, active);
            removeClassInArray(tabContent, active);
            addCustomClass(tabParent.querySelector(`[${tabsNavAttr}="${activeTabAttr}"]`), active);
            addCustomClass(tabParent.querySelector(`[${tabsContentAttr}="${activeTabAttr}"]`), active);
          });
        });
      }
  });
}

tabsFunction(tabsParrents,'data-tab','data-tab-content');



