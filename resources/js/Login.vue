<script setup>
    import axios from 'axios';
    import { reactive, ref } from 'vue';
    import { useRouter } from 'vue-router';

    let form = reactive({
        email: '',
        password: '',
    });

    let errors = ref([]);
    const router = useRouter();

    const login = async() => {
        const response = await axios.post('api/v1/auth/login',form)
        .then((res)=> {
            localStorage.setItem('id', res.data.data.id);
            localStorage.setItem('emailLogin', res.data.data.email);
            localStorage.setItem('username', res.data.data.nama);
            localStorage.setItem('role', res.data.data.jabatan);
            if(res.data.data.jabatan === "admin"){
                router.push('dashboard');
            }else if(res.data.data.jabatan === "Pegawai"){
                router.push('dashboardpegawai');
            }else if(res.data.data.jabatan === "Kasir"){
                router.push('transaksi');
            }
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
                isShow: false,
            };
        },
        created() {
            
        },
        mounted() {
        
        },
        methods: {
            clicked() {
                this.isShow = !this.isShow
            }
        },
    }
</script>

<template>
    <div class="container-md">
        <div class="d-flex flex-column justify-content-center align-items-center mt-4 py-5">
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
            <form @submit.prevent="login" method="post" class="d-grid gap-3 w-50">
                <div class="mb-3">
                    <label for="exampleInputEmail1" class="form-label">Email</label>
                    <input type="email" class="form-control" v-model="form.email" id="email" name="inputemail" placeholder="Masukkan Email" required>
                    <div class="fs-6 text-danger" v-if="errors.email">
                        {{ errors.email[0] }}
                    </div>
                </div>
                <div class="mb-3">
                    <label for="inputPassword5" class="form-label">Password</label>
                    <div class="input-group mb-3">
                        <input :type="isShow ? 'text' : 'password'" class="form-control" v-model="form.password" id="password" name="password" placeholder="Masukkan Password">
                        <span class="input-group-text bg-white">
                            <i :class="isShow ? 'fa fa-eye-slash' : 'fa fa-eye'" id="togglePassword" @click="clicked()"
                            style="cursor: pointer"></i>
                        </span>
                    </div>
                    <div class="fs-6 text-danger" v-if="errors.password">
                        {{ errors.password[0] }}
                    </div>
                </div>
                <div class="d-flex align-items-center justify-content-center">
                    <button type="submit" class="btn px-4 py-2 rounded-md ml-4 w-20">
                        Masuk
                    </Button>
                    <router-link :to="{ name:'register'}" class="underline p-3">
                        Daftar?
                    </router-link>
                </div>
            </form>
        </div>
    </div>
</template>

<style scoped>
.container-md{
    margin-top: 8rem;
    margin-bottom: 8rem;
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