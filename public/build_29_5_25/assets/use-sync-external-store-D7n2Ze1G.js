import{r as j}from"./react-CB4VEXJH.js";var E={exports:{}},R={};/**
 * @license React
 * use-sync-external-store-with-selector.production.js
 *
 * Copyright (c) Meta Platforms, Inc. and affiliates.
 *
 * This source code is licensed under the MIT license found in the
 * LICENSE file in the root directory of this source tree.
 */var l=j;function w(r,u){return r===u&&(r!==0||1/r===1/u)||r!==r&&u!==u}var y=typeof Object.is=="function"?Object.is:w,z=l.useSyncExternalStore,M=l.useRef,D=l.useEffect,O=l.useMemo,W=l.useDebugValue;R.useSyncExternalStoreWithSelector=function(r,u,v,d,a){var f=M(null);if(f.current===null){var t={hasValue:!1,value:null};f.current=t}else t=f.current;f=O(function(){function m(e){if(!s){if(s=!0,i=e,e=d(e),a!==void 0&&t.hasValue){var n=t.value;if(a(n,e))return c=n}return c=e}if(n=c,y(i,e))return n;var V=d(e);return a!==void 0&&a(n,V)?(i=e,n):(i=e,c=V)}var s=!1,i,c,b=v===void 0?null:v;return[function(){return m(u())},b===null?void 0:function(){return m(b())}]},[u,v,d,a]);var o=z(r,f[0],f[1]);return D(function(){t.hasValue=!0,t.value=o},[o]),W(o),o};E.exports=R;var I=E.exports;export{I as w};
