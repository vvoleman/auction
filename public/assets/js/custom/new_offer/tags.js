class Tags{
	tags = []
	container = "tag_container"
	constructor(tags = []){
		this.tags = tags;
	}
	addTag(text){
		this.tags.push(text);
		this.refresh();
	}
	addElement(text,i){
		const el = `
			<div class="tag" data="${i}">${text}</div>
		`;
		$("#"+this.container).append(el);
	}
	refresh(){
		$("#_tags").val(JSON.stringify(this.tags));
		$("#"+this.container).html("");
		for (var i = 0; i < this.tags.length; i++) {
			this.addElement(this.tags[i],i);
		}
		$(".tag").on('click',(e)=>{
			var id = parseInt($(e.target).attr("data"));
			if(id != null && id > -1 && id < this.tags.length){
				this.tags.splice(id,1);
			}
			e.target.remove();
			this.refresh();
		});
	}
    check(str){
	    const regexp = XRegExp("^\\pL+$");
	    console.log(regexp.test(str));
	    return regexp.test(str);
    }
}
