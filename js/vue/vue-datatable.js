Vue.component('data-list',{
  data(){
    return {
      dataTab: [],
    }
  },
  props:{
    data_resource:{
      type:Array,
      required:true
    },
    columns:{
      type:Array,
      required:true
    },
    selectable:{
      type:Boolean,
      required:false
    }
  },
  mounted: function(){
    console.log("Datatables Ready...")
  },
  methods:{
      
  },
  watch: {
    data_resource: function(value){
      this.dataTab = this.data_resource;  
      console.log(value);
    }
  },
  computed:{
    
  },
  template: `
      <div class="row" style="background: none; margin-bottom: 20px;">

        <div class="col-md-3" style="background:none; padding:0px 5px 5px 10px;">
          <select class="form-control" style="height:5px; font-size:8pt; border: 0px; border-bottom: 1px solid #FF8800; cursor: pointer" id="column_index" title="Pencarian Berdasarkan">
              <option value="{{ column.context }}" v-for="column in columns">{{ column.name }}</option>
          </select>
        </div>

        <div class="col-md-3" style="padding:0px 10px 5px 0px;">
          <input type="text" class="form-control" style="background:white;" placeholder="Kata Kunci ...." style="height: 0.9em; font-size: 8pt;  border: 0px; border-bottom: 1px solid #FF8800;">
        </div>

        <div class="col-md-4 col-md-offset-2 text-right" style="padding:0px 10px; background: none;">
          <input type="text" class="form-control text-right" value="10 Data Ditemukan" style="height: 0.9em; font-size: 8pt; border: 0px; border-bottom: 1px solid #ccc; background:white; color: #888;" disabled>
        </div>

        <div class="col-md-12" style="padding: 8px 10px 0px 10px; background: none;">
          <table id="order-listing" class="table table-bordered table-condensed" cellspacing="0" style="margin: 0px; font-size: 8pt;">
            <thead>
              <tr>
                <th class="text-center" width="5%" style="background: #FF8800; color: white;"></th>
                <th class="text-center" style="background: #FF8800; color: white;" :width="column.width" v-for="column in columns">{{ column.name }}</th>
              </tr>
            </thead>
            <tbody>

              <tr v-for="data in dataTab">
                <td class="text-center"><i class="fa fa-eye"></i></td>
                <td v-for="column in columns" :style="column.childStyle" v-html="(!column.override) ? data[column.context] : column.override(data[column.context])"></td>
              </tr>
              
            </tbody>
          </table>

        </div>

      </div>
  `
});