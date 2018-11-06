Vue.component('data-list',{
  data(){
    return {
      dataTab: [],
      search: '',
      search_context: '',
      sortBy: '',
      order: '',
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
    },
    ajax_on_loading:{
      type:Boolean,
      required:false
    },
    index_column:{
      type:String,
      required:true
    }
  },
  mounted: function(){
    console.log("Datatables Ready...")
  },
  methods:{
      selectMe: function(index){
        this.$emit('selected', index);
      }
  },
  watch: {
    data_resource: function(value){
      this.dataTab = this.data_resource;
      // console.log(this.dataTab)
    },
    columns: function(){
      // alert('okee');
      this.search_context = (this.columns.length > 0) ? this.columns[0].context : '';
      // console.log(this.search_context);
    },
    search: function(value){
      if(value == ""){ this.dataTab = this.data_resource; return }

      idx = this.search_context;

      // console.log(idx);

      var data = this.data_resource.filter(function(o){
        if(o[idx].toUpperCase().includes(value.toUpperCase())) return o;
      })

      this.dataTab = data;
    }
  },
  computed:{
    
  },
  template: `
      <div class="row" style="background: none; margin-bottom: 20px;">

        <div class="col-md-3" style="background:none; padding:0px 5px 5px 10px;">
          <select v-model="search_context" class="form-control" style="height:5px; font-size:8pt; border: 0px; border-bottom: 1px solid #ccc; cursor: pointer" id="column_index" title="Pencarian Berdasarkan">
              <option :value="column.context" v-for="column in columns">{{ column.name }}</option>
          </select>
        </div>

        <div class="col-md-3" style="padding:0px 10px 5px 0px;">
          <input type="text" class="form-control" v-model="search" style="background:white;" placeholder="Kata Kunci ...." style="height: 0.9em; font-size: 8pt;  border: 0px; border-bottom: 1px solid #ccc;">
        </div>

        <div class="col-md-4 col-md-offset-2 text-right" style="padding:0px 10px; background: none;">
          <input type="text" class="form-control text-right" :value="'Berhasil Menemukan '+dataTab.length+' Data, Dari Total Data '+data_resource.length" style="height: 0.9em; font-size: 8pt; border: 0px; border-bottom: 1px solid #ccc; background:white; color: #888;" disabled>
        </div>

        <div class="col-md-12" style="padding: 0px 10px 0px 10px; background: none; height: 400px; overflow-y: scroll; margin-top: 8px;">
          <table id="order-listing" class="table table-bordered table-condensed" cellspacing="0" style="margin: 0px; font-size: 8pt;">
            <thead>
              <tr>
                <th class="text-center" width="5%" style="background: #FF8800; color: white; position: sticky; top: 0;" v-if="selectable">-</th>
                <th class="text-center" style="background: #FF8800; color: white; cursor: pointer; position: sticky; top: 0;" :width="column.width" v-for="column in columns">
                  {{ column.name }} &nbsp;&nbsp;
                </th>
              </tr>
            </thead>
            <tbody>

              <tr>
                <td :colspan="(selectable) ? (columns.length + 1) : columns.length" class="text-center" v-if="ajax_on_loading"><i class="fa fa-search"></i> &nbsp; Sedang Mencari Data...</td>
              </tr>

              <tr>
                <td :colspan="(selectable) ? (columns.length + 1) : columns.length" class="text-center" v-if="dataTab.length == 0 && !ajax_on_loading"><i class="fa fa-frown-o"></i> &nbsp; Tidak Bisa Menemukan Data</td>
              </tr>

              <tr v-for="data in dataTab" v-if="dataTab.length > 0">
                <td class="text-center" v-if="selectable" @click="selectMe(data[index_column])"><i class="fa fa-download" style="cursor: pointer" title="Pilih Baris Ini"></i></td>
                <td v-for="column in columns" :style="column.childStyle" v-html="(!column.override) ? data[column.context] : column.override(data[column.context])"></td>
              </tr>
              
            </tbody>
          </table>

        </div>

      </div>
  `
});