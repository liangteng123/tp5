webpackJsonp([13],{199:function(t,a,e){function n(t){e(356)}var r=e(117)(e(297),e(388),n,null,null);t.exports=r.exports},297:function(t,a,e){"use strict";Object.defineProperty(a,"__esModule",{value:!0}),a.default={data:function(){return{loading:!0,loading2:!0,activeCity:"全部",isShowData:!1,listParam:{page:"1"},pageParam:{},chartParam:{page:1},currentAgent:{can_see_customer_count:0},cityData:[],listData:[],chartWidth:{width:"1100px"},myChart:null,chartPage:0,leftChangeChart:!1,rightChangeChart:!0}},mounted:function(){var t=this;t.loading=!0,t.getList(),t.getCity()},methods:{chartLeft:function(){var t=this;t.myChart.destroy(),t.loading2=!0,t.chartWidth.width="1100px",1==--t.chartParam.page?t.leftChangeChart=!1:t.rightChangeChart=!0,t.getChartData()},chartRight:function(){var t=this;t.myChart.destroy(),t.loading2=!0,t.chartWidth.width="1100px",++t.chartParam.page>=t.chartPage?t.rightChangeChart=!1:t.leftChangeChart=!0,t.getChartData()},handleClick:function(t,a){var e=(t.name,this),n=t.$attrs.code;e.listParam.city=n,e.loading=!0,e.getList()},handleCurrentChange:function(t){var a=this;a.listParam.page=t,a.loading=!0,this.getList()},checkData:function(t,a){var e=this;e.isShowData=!0,e.chartParam.admin_id=t,e.currentAgent.admin_id=t,e.currentAgent.name=a,e.rightChangeChart=!0,e.leftChangeChart=!1,e.getChartData()},getChartData:function(){var t=this;t.$ajax.get(t.$api.getModuleHost("CRM","/manage/getAdminCustomerPerfectProportion"),t.chartParam).then(function(a){var e=a.data;t.chartPage=a.last_page,t.chartPage<=1&&(t.rightChangeChart=!1,t.leftChangeChart=!1);var n=e.name;if(0==n.length){t.loading2=!1;return void(document.getElementById("J_data").innerHTML="暂无数据")}var r=e.perfection_degree,i=e.admin_perfection_degree;n.length<=50?t.chartWidth={width:"1100px"}:t.chartWidth={width:40*n.length+"px"},t.currentAgent.can_see_customer_count=a.can_see_customer_count,t.currentAgent.average_perfection_degree=a.average_perfection_degree;var o={chart:{type:"column"},legend:{enabled:!1},title:{text:""},xAxis:{categories:n},yAxis:{allowDecimals:!0,min:0,title:{text:""},labels:{align:"center"}},tooltip:{formatter:function(){return"<b>"+this.x+"</b><br/>"+this.series.name+": "+this.y+"%<br/>"}},plotOptions:{column:{stacking:"normal",pointWidth:5,dataLabels:{enabled:!0,color:"#e3e3e3",formatter:function(){return this.y+"%"}}}},series:[{name:"客户信息完善比例",data:r,color:"#F7A35C",stack:"male"},{name:"此专员贡献字段比例",data:i,color:"#90ED7D",stack:"male"}]};setTimeout(function(){t.myChart=t.$HighCharts.chart("J_data",o),t.loading2=!1},100)})},getList:function(){var t=this;t.$ajax.get(t.$api.getModuleHost("CRM","/manage/getadminlist"),t.listParam).then(function(a){t.listData=a.data,t.pageParam.total=a.total,t.loading=!1})},getCity:function(){var t=this;t.$ajax.get(t.$api.getModuleHost("CRM","/manage/getcitys")).then(function(a){t.cityData=a.data})},sortChange:function(t){var a=this,e=e="ascending"==t.order?0:1;a.listParam.sort=t.prop,a.listParam.order=e,a.loading=!0,a.getList()},hideChartLayer:function(){var t=this;t.loading2=!0,t.isShowData=!1,t.myChart.destroy(),t.rightChangeChart=!0,t.leftChangeChart=!1,t.chartParam.page=1}},components:{}}},330:function(t,a,e){a=t.exports=e(191)(!0),a.push([t.i,".container{min-width:1366px;overflow-x:auto}.city-select-txt{font-size:14px;margin:10px 0}.table-title{cursor:pointer}.data-layer{width:100%;height:100%;background:rgba(0,0,0,.5);position:fixed;top:0;left:0;z-index:10;text-align:center}.data-layer .data-content{position:absolute;width:1100px;height:600px;background:#fff;text-align:left;top:50%;left:50%;margin-top:-300px;margin-left:-550px;border-radius:3px}.data-layer .data-content .data-content-wrap{overflow-x:auto}.data-layer .data-content .change-chart{position:absolute;top:50%;width:50px;height:60px;background:rgba(0,0,0,.5);color:#fff;z-index:10;font-size:20px;text-align:center;line-height:60px;margin-top:-30px;cursor:pointer}.data-layer .data-content .change-chart:hover{background:rgba(0,0,0,.4)}.data-layer .data-content .change-chart-left{left:0}.data-layer .data-content .change-chart-right{right:0}.data-layer .data-content .data-inner-content{height:500px;padding-top:100px;text-align:center;line-height:500px;font-size:14px}.data-layer .data-content .agent-info{font-size:14px;position:absolute;top:20px;left:20px;color:#333}.data-layer .data-content .agent-info span{display:inline-block;margin-right:40px;z-index:20}.data-layer .data-content .agent-info span i{color:#20a0ff}.data-layer .data-content .legend-wrap{position:absolute;top:70px;left:390px;text-align:center;font-size:14px}.data-layer .data-content .legend-wrap span{display:inline-block;width:30px;height:15px;border-radius:3px;vertical-align:bottom}.data-layer .data-content .legend-wrap span:first-child{background:#f7a35c}.data-layer .data-content .legend-wrap span:last-child{background:#90ed7d}","",{version:3,sources:["D:/VUEPROJECT/boss_crm/src/components/mngview/AgentData.vue"],names:[],mappings:"AACA,WACE,iBAAkB,AAClB,eAAiB,CAClB,AACD,iBACE,eAAgB,AAChB,aAAe,CAChB,AACD,aACE,cAAgB,CACjB,AACD,YACE,WAAY,AACZ,YAAa,AACb,0BAA+B,AAC/B,eAAgB,AAChB,MAAO,AACP,OAAQ,AACR,WAAY,AACZ,iBAAmB,CACpB,AACD,0BACE,kBAAmB,AACnB,aAAc,AACd,aAAc,AACd,gBAAiB,AACjB,gBAAiB,AACjB,QAAS,AACT,SAAU,AACV,kBAAmB,AACnB,mBAAoB,AACpB,iBAAmB,CACpB,AACD,6CACE,eAAiB,CAClB,AACD,wCACE,kBAAmB,AACnB,QAAS,AACT,WAAY,AACZ,YAAa,AACb,0BAA+B,AAC/B,WAAY,AACZ,WAAY,AACZ,eAAgB,AAChB,kBAAmB,AACnB,iBAAkB,AAClB,iBAAkB,AAClB,cAAgB,CACjB,AACD,8CACE,yBAA+B,CAChC,AACD,6CACE,MAAQ,CACT,AACD,8CACE,OAAS,CACV,AACD,8CACE,aAAc,AACd,kBAAmB,AACnB,kBAAmB,AACnB,kBAAmB,AACnB,cAAgB,CACjB,AACD,sCACE,eAAgB,AAChB,kBAAmB,AACnB,SAAU,AACV,UAAW,AACX,UAAY,CACb,AACD,2CACE,qBAAsB,AACtB,kBAAmB,AACnB,UAAY,CACb,AACD,6CACE,aAAe,CAChB,AACD,uCACE,kBAAmB,AACnB,SAAU,AACV,WAAY,AACZ,kBAAmB,AACnB,cAAgB,CACjB,AACD,4CACE,qBAAsB,AACtB,WAAY,AACZ,YAAa,AACb,kBAAmB,AACnB,qBAAuB,CACxB,AACD,wDACE,kBAAoB,CACrB,AACD,uDACE,kBAAoB,CACrB",file:"AgentData.vue",sourcesContent:["\n.container {\n  min-width: 1366px;\n  overflow-x: auto;\n}\n.city-select-txt {\n  font-size: 14px;\n  margin: 10px 0;\n}\n.table-title {\n  cursor: pointer;\n}\n.data-layer {\n  width: 100%;\n  height: 100%;\n  background: rgba(0, 0, 0, 0.5);\n  position: fixed;\n  top: 0;\n  left: 0;\n  z-index: 10;\n  text-align: center;\n}\n.data-layer .data-content {\n  position: absolute;\n  width: 1100px;\n  height: 600px;\n  background: #fff;\n  text-align: left;\n  top: 50%;\n  left: 50%;\n  margin-top: -300px;\n  margin-left: -550px;\n  border-radius: 3px;\n}\n.data-layer .data-content .data-content-wrap {\n  overflow-x: auto;\n}\n.data-layer .data-content .change-chart {\n  position: absolute;\n  top: 50%;\n  width: 50px;\n  height: 60px;\n  background: rgba(0, 0, 0, 0.5);\n  color: #fff;\n  z-index: 10;\n  font-size: 20px;\n  text-align: center;\n  line-height: 60px;\n  margin-top: -30px;\n  cursor: pointer;\n}\n.data-layer .data-content .change-chart:hover {\n  background: rgba(0, 0, 0, 0.4);\n}\n.data-layer .data-content .change-chart-left {\n  left: 0;\n}\n.data-layer .data-content .change-chart-right {\n  right: 0;\n}\n.data-layer .data-content .data-inner-content {\n  height: 500px;\n  padding-top: 100px;\n  text-align: center;\n  line-height: 500px;\n  font-size: 14px;\n}\n.data-layer .data-content .agent-info {\n  font-size: 14px;\n  position: absolute;\n  top: 20px;\n  left: 20px;\n  color: #333;\n}\n.data-layer .data-content .agent-info span {\n  display: inline-block;\n  margin-right: 40px;\n  z-index: 20;\n}\n.data-layer .data-content .agent-info span i {\n  color: #20a0ff;\n}\n.data-layer .data-content .legend-wrap {\n  position: absolute;\n  top: 70px;\n  left: 390px;\n  text-align: center;\n  font-size: 14px;\n}\n.data-layer .data-content .legend-wrap span {\n  display: inline-block;\n  width: 30px;\n  height: 15px;\n  border-radius: 3px;\n  vertical-align: bottom;\n}\n.data-layer .data-content .legend-wrap span:first-child {\n  background: #F7A35C;\n}\n.data-layer .data-content .legend-wrap span:last-child {\n  background: #90ED7D;\n}\n"],sourceRoot:""}])},356:function(t,a,e){var n=e(330);"string"==typeof n&&(n=[[t.i,n,""]]),n.locals&&(t.exports=n.locals);e(192)("ef39ed16",n,!0)},388:function(t,a){t.exports={render:function(){var t=this,a=t.$createElement,e=t._self._c||a;return e("div",{directives:[{name:"loading",rawName:"v-loading.body",value:t.loading,expression:"loading",modifiers:{body:!0}}],staticClass:"container",attrs:{"element-loading-text":"拼命加载中"}},[e("p",{staticClass:"city-select-txt"},[t._v("城市筛选")]),t._v(" "),e("el-tabs",{attrs:{type:"card"},on:{"tab-click":t.handleClick},model:{value:t.activeCity,callback:function(a){t.activeCity=a},expression:"activeCity"}},[e("el-tab-pane",{attrs:{label:"全部",name:"全部",code:"0"}}),t._v(" "),t._l(t.cityData,function(t){return e("el-tab-pane",{attrs:{label:t.city_name,name:t.city_name,code:t.city_code}})})],2),t._v(" "),e("el-table",{staticStyle:{width:"100%"},attrs:{data:t.listData,border:""},on:{"sort-change":t.sortChange}},[e("el-table-column",{attrs:{prop:"admin_id",label:"专员ID",width:"100"}}),t._v(" "),e("el-table-column",{attrs:{label:"专员姓名",width:"100"},scopedSlots:t._u([{key:"default",fn:function(a){return[e("div",{staticStyle:{cursor:"pointer",width:"70px","text-overflow":"ellipsis",color:"#20a0ff","white-space":"nowrap",overflow:"hidden"},attrs:{title:a.row.name},on:{click:function(e){t.checkData(a.row.admin_id,a.row.name)}}},[t._v(t._s(a.row.name))])]}}])}),t._v(" "),e("el-table-column",{attrs:{prop:"city",label:"所在城市",width:"110"}}),t._v(" "),e("el-table-column",{attrs:{prop:"all_customer_count",label:"成交客户数",width:"130","label-class-name":"table-title",sortable:"custom"}}),t._v(" "),e("el-table-column",{attrs:{prop:"create_by_own_customer_count",label:"自己创建客户数",width:"160","label-class-name":"table-title",sortable:"custom"}}),t._v(" "),e("el-table-column",{attrs:{prop:"can_see_customer_count",label:"可查看客户数",width:"150","label-class-name":"table-title",sortable:"custom"}}),t._v(" "),e("el-table-column",{attrs:{prop:"wait_for_create_customer",label:"待创建客户数",width:"150","label-class-name":"table-title",sortable:"custom"}}),t._v(" "),e("el-table-column",{attrs:{prop:"create_by_own_customer_proportion",label:"创建客户比例",width:"150","label-class-name":"table-title",sortable:"custom"}}),t._v(" "),e("el-table-column",{attrs:{prop:"all_perfect_fields",label:"总完善字段数",width:"150","label-class-name":"table-title",sortable:"custom"}}),t._v(" "),e("el-table-column",{attrs:{prop:"average_each_customer_field_count",label:"每客户平均字段数",width:"180","label-class-name":"table-title",sortable:"custom"}}),t._v(" "),e("el-table-column",{attrs:{prop:"median_customer_field",label:"每客户字段中位数",width:"180","label-class-name":"table-title",sortable:"custom"}}),t._v(" "),e("el-table-column",{attrs:{prop:"max_customer_field_count",label:"单个客户最高字段数",width:"190","label-class-name":"table-title",sortable:"custom"}}),t._v(" "),e("el-table-column",{attrs:{prop:"min_customer_field_count",label:"单个客户最少字段数",width:"190","label-class-name":"table-title",sortable:"custom"}})],1),t._v(" "),e("el-pagination",{staticStyle:{"margin-top":"20px"},attrs:{"page-size":10,layout:"total, prev, pager, next",total:t.pageParam.total},on:{"current-change":t.handleCurrentChange}}),t._v(" "),e("div",{directives:[{name:"show",rawName:"v-show",value:t.isShowData,expression:"isShowData"}],staticClass:"data-layer",attrs:{id:"J_dataWrap"}},[e("div",{staticClass:"data-content"},[e("div",{directives:[{name:"loading",rawName:"v-loading",value:t.loading2,expression:"loading2"}],staticClass:"data-content-wrap",attrs:{"element-loading-text":"拼命加载中"}},[e("button",{staticClass:"el-message-box__headerbtn",staticStyle:{"z-index":"20"},attrs:{type:"button","aria-label":"Close"},on:{click:t.hideChartLayer}},[e("i",{staticClass:"el-message-box__close el-icon-close"})]),t._v(" "),e("div",{staticClass:"agent-info"},[e("span",[t._v("专员id  "),e("i",[t._v(t._s(t.currentAgent.admin_id)+"  ")])]),t._v(" "),e("span",[t._v("专员姓名  "),e("i",[t._v(t._s(t.currentAgent.name))])]),t._v(" "),e("span",[t._v("可查看客户总数  "),e("i",[t._v(t._s(t.currentAgent.can_see_customer_count))])]),t._v(" "),e("span",[t._v("客户信息平均完善比例  "),e("i",[t._v(t._s(t.currentAgent.average_perfection_degree))])])]),t._v(" "),t._m(0),t._v(" "),e("div",{directives:[{name:"show",rawName:"v-show",value:t.leftChangeChart,expression:"leftChangeChart"}],staticClass:"el-icon-arrow-left change-chart change-chart-left",on:{click:t.chartLeft}}),t._v(" "),e("div",{directives:[{name:"show",rawName:"v-show",value:t.rightChangeChart,expression:"rightChangeChart"}],staticClass:"el-icon-arrow-right change-chart change-chart-right",on:{click:t.chartRight}}),t._v(" "),e("div",{staticClass:"data-inner-content",style:[t.chartWidth],attrs:{id:"J_data"}})])])])],1)},staticRenderFns:[function(){var t=this,a=t.$createElement,e=t._self._c||a;return e("div",{staticClass:"legend-wrap"},[e("span"),t._v(" 客户信息完善比例  \n\t\t\t\t\t\t"),e("span"),t._v(" 此专员贡献字段比例\n\t\t\t\t\t")])}]}}});
//# sourceMappingURL=13.f6121f9df4e4c5e4c333.js.map