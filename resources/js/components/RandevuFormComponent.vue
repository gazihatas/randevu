<template>
    <div class="container">

        <div v-if="completeForm">
            <!-- Hata ekranı - Ad/Soyad - email/ telefon -->
            <div class="row">
                <!-- Hata ekranı -->
                <div class="row">
                    <div class="col-md-12">
                        <ul>
                            <li class="errors" v-for="i in errors">
                                {{ i }}
                            </li>
                        </ul>
                    </div>
                </div>
                <!-- Ad Soyad -->
                <div class="col-md-12">
                    <div class="form-group">
                        <input type="text" class="form-control" v-model="name" placeholder="Ad Soyad">
                    </div>
                </div>
                <!-- Email - Telefon-->
                <div class="row mt-2">
                    <div class="col-md-6">
                        <div class="form-group">
                            <input type="text" class="form-control" v-model="email" placeholder="Email">
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <input type="text" v-mask="'##-###-###-##-##'" class="form-control" v-model="phone" placeholder="Telefon">
                        </div>
                    </div>
                </div>
            </div>
            <!-- Date-->
            <div class="row mt-2">
                <div class="col-md-12">
                    <div class="form-group">
                        <input type="date" @change="selectDate" v-model="date" class="form-control">
                    </div>
                </div>
            </div>
            <!-- Saatler-->
            <div class="row mt-2">
                <div class="col-md-12">
                    <ul class="select-time-ul">
                        <li v-for="item in workingHours" class="select-time">
                            <input v-if="item.isActive" type="radio" v-model="workingHour" v-bind:value="item.id">
                            <span>{{item.hours}}</span>
                        </li>

                    </ul>
                </div>
            </div>
            <!-- Gönderim Tipi: Sms/Email-->
            <div class="row mt-2">
                <div class="col-md-12">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="">Sms</label>
                                <input type="radio" v-model="notification_type" value="0">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="">Email</label>
                                <input type="radio" v-model="notification_type" value="1">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Textrarea -->
            <div class="row mt-2">
                <div class="col-md-12">
                    <div class="form-group">
                        <textarea v-model="text"  class="form-control" id="" cols="30" rows="10"></textarea>
                    </div>
                </div>
            </div>
            <!-- Randevu oluştur butonu-->
            <div class="row mt-2">
                <div class="col-md-12">
                    <button v-on:click="store" class="btn btn-success">Randevu Oluştur</button>
                </div>
            </div>
        </div>

        <div>
            <div class="complete-form">
                <i class="fa fa-check-circle-o" aria-hidden="true"></i>
                aa
            </div>
        </div>

    </div>
</template>

<script>
export default {
    data(){
      return{
          completeForm:false,
          errors:[],
          notification_type:null,
          workingHour:0,
          name:null,
          email:null,
          phone:null,
          text:null,
          date:new Date().toISOString().slice(0,10),
          workingHours:[]
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
            if(this.notification_type && this.name && this.validEmail(this.email) && this.phone && this.workingHour!=0)
            {
                axios.post('http://randevu.test/api/appointment-store',{
                    fullName:this.name,
                    phone:this.phone,
                    email:this.email,
                    date:this.date,
                    workingHour:this.workingHour,
                    notification_type:this.notification_type

                }).then((res)=>{
                    console.log(res);
                })
                console.log("Form Gönderilmeye Hazır.");
            }

            this.errors = [];

            if(!this.notification_type)
            {
                this.errors.push('Bildirim Tipi Seçilmelidir.');
            }

            if(!this.name)
            {
                this.errors.push('İsim Soyisim Girilmelidir.');
            }

            if(!this.email || !this.validEmail(this.email))
            {
                this.errors.push('Email Girilmelidir ve Formatı Doğru olmalıdır.');
            }

            if(!this.phone)
            {
                this.errors.push('Telefon Numarası Girilmelidir.');
            }

            if(!this.workingHour)
            {
                this.errors.push('Çalışma saati seçilmelidir');
            }
        },
        selectDate:function(){
            axios.get('http://randevu.test/api/working-hours/${this.date}')
                .then((res)=>{
                    this.workingHours = res.data;
                });
        },
        validEmail: function (email) {
            let re = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
            return re.test(email);
        }

    }
}
</script>

<style scoped>

</style>
