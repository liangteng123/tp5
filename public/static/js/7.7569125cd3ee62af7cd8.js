webpackJsonp([7],{208:function(e,t,n){function a(e){n(350)}var i=n(117)(n(306),n(382),a,null,null);e.exports=i.exports},306:function(e,t,n){"use strict";Object.defineProperty(t,"__esModule",{value:!0}),t.default={name:"mngview",data:function(){return{navActive:"agentData"}},mounted:function(){},methods:{handleClick:function(e,t){var n=e.name;this.$router.push({path:"/foreground/mngview/"+n})},changeActiveNav:function(){this.navActive="fieldData"}},components:{}}},324:function(e,t,n){t=e.exports=n(191)(!0),t.push([e.i,"","",{version:3,sources:[],names:[],mappings:"",file:"mngview.page.vue",sourceRoot:""}])},350:function(e,t,n){var a=n(324);"string"==typeof a&&(a=[[e.i,a,""]]),a.locals&&(e.exports=a.locals);n(192)("587772ef",a,!0)},382:function(e,t){e.exports={render:function(){var e=this,t=e.$createElement,n=e._self._c||t;return n("div",[n("el-row",{attrs:{type:"flex",justify:"center"}},[n("el-col",{attrs:{span:23}},[n("el-tabs",{on:{"tab-click":e.handleClick},model:{value:e.navActive,callback:function(t){e.navActive=t},expression:"navActive"}},[n("el-tab-pane",{attrs:{label:"按专员维度查看",name:"agentData"}}),e._v(" "),n("el-tab-pane",{attrs:{label:"按办会人维度查看",name:"customerData"}}),e._v(" "),n("el-tab-pane",{attrs:{label:"按字段维度查看",name:"fieldData"}})],1),e._v(" "),n("router-view",{on:{changeNav:e.changeActiveNav}})],1)],1)],1)},staticRenderFns:[]}}});
//# sourceMappingURL=7.7569125cd3ee62af7cd8.js.map