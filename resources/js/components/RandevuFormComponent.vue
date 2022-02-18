<template>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                    <div class="form-group">
                        <input type="text" class="form-control" v-model="name" placeholder="Ad Soyad">
                    </div>
            </div>
                    <div class="row mt-2">
                        <div class="col-md-6">
                            <div class="form-group">
                                <input type="text" class="form-control" v-model="email" placeholder="Email">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <input type="text" class="form-control" v-model="phone" placeholder="Telefon">
                            </div>
                        </div>
                    </div>

        </div>

        <!-- Date-->
        <div class="row mt-2">
            <div class="col-md-12">
                <div class="form-group">
                    <input type="date" @change="selectDate" v-model="date" class="form-comtrol">
                </div>
            </div>
        </div>

        <!-- Saatler-->
        <div class="row mt-2">
            <div class="col-md-12">
                <ul class="select-time-ul">
                    <li v-for="item in workingHours" class="select-time">
                        <input type="radio" v-model="workingHour">
                        <span>{{item.hours}}</span>
                    </li>

                </ul>
            </div>
        </div>

        <div class="row mt-2">
            <div class="col-md-12">
                <div class="form-group">
                    <textarea v-model="text"  class="form-control" id="" cols="30" rows="10"></textarea>
                </div>
            </div>
        </div>

        <div class="row mt-2">
            <div class="col-md-12">
                <button v-on:click="store" class="btn btn-success">Randevu Oluştur</button>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data(){
      return{
          name:'',
          email:'',
          phone:'',
          text:'',
          date:new Date().toISOString().slice(0,10),
          workingHours:[],
          workingHour:''
      }
    },
    mounted() {
        axios.get('http://randevu.test/api/working-hours')
            .then((res)=>{
                this.workingHours = res.data;
            });

    },
    methods:{
        store:function (){
            console.log("Tıklandı.");
        },
        selectDate:function(){
            console.log("Tarih Değişti");
        }
    }
}
</script>

<style scoped>

</style>
