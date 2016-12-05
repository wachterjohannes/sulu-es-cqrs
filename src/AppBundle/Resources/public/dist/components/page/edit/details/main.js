define(["underscore","jquery","text!./form.html"],function(a,b,c){return{defaults:{templates:{form:c,url:"/admin/api/pages<% if (!!id) { %>/<%= id %><% } %>"},translations:{title:"public.title"}},layout:{content:{width:"fixed",leftSpace:!0,rightSpace:!0}},initialize:function(){this.render(),this.bindDomEvents(),this.bindCustomEvents()},render:function(){this.$el.html(this.templates.form({translations:this.translations})),this.form=this.sandbox.form.create("#pages-form"),this.form.initialized.then(function(){this.sandbox.form.setData("#pages-form",this.data||{})}.bind(this))},bindDomEvents:function(){this.$el.find("input, textarea").on("keypress",function(){this.sandbox.emit("sulu.tab.dirty")}.bind(this))},bindCustomEvents:function(){this.sandbox.on("sulu.tab.save",this.save.bind(this))},save:function(){if(this.sandbox.form.validate("#pages-form")){var a=this.sandbox.form.getData("#pages-form"),b=this.templates.url({id:this.data.id});this.sandbox.util.save(b,this.data.id?"PUT":"POST",a).then(function(a){this.sandbox.emit("sulu.tab.saved",a)}.bind(this))}},loadComponentData:function(){var a=b.Deferred();return a.resolve(this.options.data()),a}}});