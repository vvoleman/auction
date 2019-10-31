class RegionsLoader {
    regions = {};
    id_c = "countryselect";
    id_r = "regionselect";
    select;
    selected;

    constructor(regions=null,selected=null){
        this.select = $(`#${this.id_c}`);
        if(regions != null && selected != null){
            this.selected = selected;
            regions = JSON.parse(regions);
            this.regions[regions.short] = regions.regions;

            this.appendRegions(regions.regions);
        }else{
            this.firstLoad();
        }
        this.setListeners();

    }
    firstLoad(){
        const short = $("#"+this.id_c).val();
        let ajax = this.query(short);
        ajax.done((data)=>{
            this.regions[short] = data;
            this.appendRegions(data);
        });
        ajax.fail((err)=>{
           console.log(err);
        });

    }
    setListeners(){
        this.select.on("change",()=>{
            this.setDisabled(true);
            if(this.selected != null){
                this.selected = null;
            }
            let short = this.select.val();
            let regions = [];
            if(this.regions[short] == null){
                let ajax = this.query(short);
                ajax.done((data)=>{
                    this.regions[short] = data;
                    this.appendRegions(data);
                });
                ajax.fail((err)=>{
                    console.log(err);
                });
            }else{
                regions = this.regions[short];
                this.appendRegions(regions);
            }
        });
    }
    appendRegions(regions){
        var select = $("#"+this.id_r);
        select.html("");
        for(var i = 0;i<regions.length;i++){
            select.append(`
                <option value="${regions[i].id}" ${(this.selected == regions[i].id) ? "selected" : ""}>${regions[i].name}</option>
            `);
        }
        this.setDisabled(false);
    }
    setDisabled(boo){
        this.select.attr('disabled',boo);
        $("#"+this.id_r).attr('disabled',boo);
    }
    query(short){
        return $.get("/ajax/settings/getRegionsByCountry",{id:short});
    }
}
