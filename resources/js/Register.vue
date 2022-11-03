<script setup>
    import axios from 'axios';
    import { reactive, ref } from 'vue';
    import { useRouter } from 'vue-router';

    let form = reactive({
        email: '',
        nama: '',
        telepon: '',
        password: '',
        password_confirmation: '',
    });

    let errors = ref([]);
    const router = useRouter();

    const register = async() => {
        const response = await axios.post('api/v1/auth/register',form)
        .then((res)=> {
            router.push({name: "login"})
        })
        .catch((err) =>{
            errors.value = err.response.data.message
        });
    }
</script>

<script>
    export default {
        components: {
        },
        data() {
            return {
                isShowPass: false,
                isShowConfirmPass: false,
                toastShow: false,
                toastShowError: false,
            };
        },
        created() {
            console.log(this.toastShow);
            console.log(this.toastShowError);
        },
        mounted() {
        
        },
        methods: {
            clickedPass() {
                this.isShowPass = !this.isShowPass
            },
            clickedConfirmPass() {
                this.isShowConfirmPass = !this.isShowConfirmPass
            },
            ToastSuccess(){
                this.toastShow = true
                console.log(this.toastShow)
            },
            ToastError(){
                this.toastShowError = true
                console.log(this.toastShowError)
            }
        },
    }
</script>

<template>
    <div class="container-md">
        <div class="d-flex flex-column justify-content-center align-items-center mt-4 py-5">
            <div v-if="toastShow" class="alert alert-success alert-dismissible d-flex align-items-center" role="alert">
                <i class="fa-sharp fa-solid fa-circle-check"></i>
                <div> An example success alert with an icon </div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            <div v-if="toastShowError" class="alert alert-danger alert-dismissible d-flex align-items-center" role="alert">
                <i class="fa-solid fa-circle-exclamation"></i>
                <div> An example success alert with an icon </div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            <div class="py-3">
                <a href="/">
                    <svg
                        width="13rem"
                        height="13rem"
                        viewBox="0 0 287 290"
                        fill="none"
                        xmlns="http://www.w3.org/2000/svg"
                        >
                        <ellipse
                            cx="143.5"
                            cy="145"
                            rx="143.5"
                            ry="145"
                            fill="#424242"
                        />
                        <path
                            fill-rule="evenodd"
                            clip-rule="evenodd"
                            d="M267 144.5C267 213.907 211.388 270 143 270C74.6116 270 19 213.907 19 144.5C19 133.478 20.4024 122.792 23.0357 112.612L92.8 112.9C98.5 112.9 101.2 114.4 101.2 118.15C101.2 123.1 93.25 129.85 77.65 139.9C96.55 150.1 105.85 159.1 105.85 167.5C105.85 171.7 103.15 173.65 97.75 173.65H76.9V117.4H47.8V199H90.7C107.05 199 118.75 198.55 126.4 193.9C134.65 188.95 138.85 181 138.85 170.65C138.85 158.95 132.25 147.55 119.5 138.55C129.1 130.6 133.75 122.5 133.75 112.6C133.75 96.25 121.9 87.85 98.35 87.85H32.3182C52.7852 46.9712 94.707 19 143 19C191.293 19 233.215 46.9712 253.682 87.85H218.651C196.451 87.85 179.651 93.55 167.501 105.7C154.901 118.3 147.251 137.65 147.251 159.25C147.251 178 153.251 196.45 165.101 214.6L188.801 199C181.751 187.6 178.001 175.9 177.401 163.9H208.751V199H238.751V117.4H208.751V138.25H180.401C187.001 120.25 199.301 112.9 220.601 112.9L262.965 112.617C265.598 122.795 267 133.48 267 144.5ZM276 144.5C276 218.782 216.454 279 143 279C69.5461 279 10 218.782 10 144.5C10 70.2177 69.5461 10 143 10C216.454 10 276 70.2177 276 144.5Z"
                            fill="white"
                        />
                    </svg>
                </a>
            </div>
            <form @submit.prevent="register" method="post" class="d-grid w-50">
                <div class="mb-3">
                    <label for="InputEmail" class="form-label">Email</label>
                    <input type="email" v-model="form.email" name="email" class="form-control" id="InputEmail" placeholder="Masukkan Email" aria-describedby="emailHelp" required>
                    <div class="fs-6 text-danger" v-if="errors.email">
                        {{ errors.email[0] }}
                    </div>
                </div>
                <div class="mb-3">
                    <label for="InputNama" class="form-label">Nama Lengkap</label>
                    <input type="text" v-model="form.nama" name="nama" class="form-control" id="InputNama" placeholder="Masukkan Nama Lengkap" aria-describedby="emailHelp" >
                    <div class="fs-6 text-danger" v-if="errors.nama">
                        {{ errors.nama[0] }}
                    </div>
                </div>
                <div class="mb-3">
                    <label for="InputNomorTelepon" class="form-label">Nomor Telepon</label>
                    <input type="text" v-model="form.telepon" name="telepon" class="form-control" id="InputNomorTelepon" placeholder="Masukkan Nomor Telepon" aria-describedby="emailHelp" >
                    <div class="fs-6 text-danger" v-if="errors.telepon">
                        {{ errors.telepon[0] }}
                    </div>
                </div>
                <div class="mb-3">
                    <label for="inputPassword" class="form-label">Password</label>
                    <div class="input-group mb-3">
                        <input :type="isShowPass ? 'text' : 'password'" class="form-control" v-model="form.password" id="password" name="pass" placeholder="Masukkan Password">
                        <span class="input-group-text bg-white">
                            <i :class="isShowPass ? 'fa fa-eye-slash' : 'fa fa-eye'" id="togglePassword" @click="clickedPass()"
                            style="cursor: pointer"></i>
                        </span>
                    </div>
                    <div class="fs-6 text-danger" v-if="errors.password">
                        {{ errors.password[0] }}
                    </div>
                    <div id="passwordHelpBlock" class="form-text">
                        Kata sandi Anda harus terdiri dari 6-20 karakter, berisi huruf dan angka, dan tidak boleh mengandung spasi, karakter khusus, atau emoji.
                    </div>
                </div>
                <div class="mb-3">
                    <label for="inputConfirmPassword" class="form-label">Konfirmasi Password</label>
                    <div class="input-group mb-3">
                        <input :type="isShowConfirmPass ? 'text' : 'password'" v-model="form.password_confirmation" name="password_confirmation" id="password_confirmation" class="form-control" placeholder="Masukkan Konfirmasi Password">
                        <span class="input-group-text bg-white">
                            <i :class="isShowConfirmPass ? 'fa fa-eye-slash' : 'fa fa-eye'" id="toggleConfirmPassword" @click="clickedConfirmPass()"
                            style="cursor: pointer"></i>
                        </span>
                    </div>
                    <div class="fs-6 text-danger" v-if="errors.password_confirmation">
                        {{ errors.password_confirmation[0] }}
                    </div>
                </div>
                <div class="d-flex align-items-center justify-content-center">
                    <button type="submit" class="btn px-4 py-2 rounded-md ml-4 w-20">
                        Daftar
                    </Button>
                    <router-link :to="{ name:'login' }" class="underline p-3">
                        Sudah Daftar?
                    </router-link>
                </div>
            </form>
        </div>
        <!-- <button type="button" class="btn" @click="ToastSuccess()" id="liveToastBtn">Show live toast</button> -->
    </div>
</template>

<style scoped>
.container-md{
    margin-top: 1.5rem;
    margin-bottom: 1.5rem;
}
.form-label{
    font-family: "Inter";
    font-size: larger;
    font-weight: 500;
}
.btn{
    font-family: "Inter";
    font-size: larger;
    font-weight: 600;
    background-color: #4a4a4a;
    color: #fff;
}
.btn:hover{
    background-color: #A6A6A6;
    color: #4a4a4a;
}
.underline{
    font-family: "Inter";
    font-size: large;
    font-weight: 600;
    color: rgb(179, 179, 179);
}
.underline:hover {
    color: black;
}
</style>