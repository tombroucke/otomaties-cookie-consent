(()=>{"use strict";const e=document.querySelectorAll("button[data-common-cookie]");for(let t=0;t<e.length;t++){const c=e[t],o=c.getAttribute("data-common-cookie"),n=c.getAttribute("data-category");c.addEventListener("click",(function(e){e.preventDefault();const t=document.querySelector("."+o+"--name"),c=document.querySelector("."+o+"--domain"),r=document.querySelector("."+o+"--expiration"),i=document.querySelector("."+o+"--description"),a=document.querySelector("."+o+"--regex").getAttribute("data-regex");if("undefined"==typeof acf)return;var l=document.querySelector(".acf-field-cookie-consent-category-settings-occ-"+n+"-cookie-table");l.querySelector(".acf-button").click();const u=l.querySelectorAll(".acf-row").length-1,d=l.querySelector(".acf-row:nth-child("+u+")"),s=d.querySelector(".acf-field-cookie-consent-category-settings-occ-"+n+"-cookie-table-name input"),y=d.querySelector(".acf-field-cookie-consent-category-settings-occ-"+n+"-cookie-table-domain input"),f=d.querySelector(".acf-field-cookie-consent-category-settings-occ-"+n+"-cookie-table-expiration input"),g=d.querySelector(".acf-field-cookie-consent-category-settings-occ-"+n+"-cookie-table-description input"),k=d.querySelector(".acf-field-cookie-consent-category-settings-occ-"+n+'-cookie-table-regex input[type="hidden"]'),m=d.querySelector(".acf-field-cookie-consent-category-settings-occ-"+n+'-cookie-table-regex input[type="checkbox"]');s.value=t.innerHTML.trim(),y.value=c.innerHTML.trim(),f.value=r.innerHTML.trim(),g.value=i.innerHTML.trim(),k.checked=!!a,m.checked=!!a}))}})();