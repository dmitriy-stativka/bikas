import '../vendor/lightbox';

import vars from '../_vars';
import { addCustomClass, toggleCustomClass, removeCustomClass } from "../functions/customFunctions";

const {portfolioGallery} = vars;


portfolioGallery.forEach((item)=>{
  lightGallery(item, {
    download:false
  });
})



