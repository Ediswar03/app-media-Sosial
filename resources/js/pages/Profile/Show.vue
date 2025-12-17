<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, usePage, useForm } from '@inertiajs/vue3'; // 1. Tambah useForm
import { ref, computed } from 'vue';

// Menerima data 'user' dari Controller
const props = defineProps({
    user: Object
});

// Mengambil data user yang sedang login
const authUser = usePage().props.auth.user;
const isMyProfile = computed(() => authUser && authUser.id === props.user.id);

// State untuk Tab Navigasi
const activeTab = ref('Posts');
const tabs = ['Posts', 'Followers', 'Followings', 'Photos'];

// State untuk Form Edit (Sederhana)
const showEditProfile = ref(false);

// --- BAGIAN LOGIC UPLOAD GAMBAR (BARU) ---

// 2. Inisialisasi Form Inertia
const form = useForm({
    avatar: null,
    cover: null,
});

// 3. Logic Upload Cover
const uploadCover = (e) => {
    // Ambil file dari input
    form.cover = e.target.files[0];
    
    // Kirim ke route backend 'profile.updateImages'
    form.post(route('profile.updateImages'), {
        preserveScroll: true, // Agar halaman tidak scroll ke atas
        onSuccess: () => {
            e.target.value = null; // Reset input file setelah sukses
            console.log('Cover updated!');
        },
    });
};

// 4. Logic Upload Avatar
const uploadAvatar = (e) => {
    form.avatar = e.target.files[0];
    
    form.post(route('profile.updateImages'), {
        preserveScroll: true,
        onSuccess: () => {
            e.target.value = null;
            console.log('Avatar updated!');
        },
    });
};

// Fungsi Trigger (Membuka dialog file window)
const triggerAvatarUpload = () => document.getElementById('avatarInput').click();
const triggerCoverUpload = () => document.getElementById('coverInput').click();

</script>

<template>
    <Head :title="user.name" />

    <AuthenticatedLayout>
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 py-8">
            
            <div class="bg-white shadow sm:rounded-lg overflow-hidden relative">
                
                <div class="h-[200px] w-full bg-gray-300 relative group">
                    <img 
                        :src="user.cover_url" 
                        class="w-full h-full object-cover" 
                        alt="Cover Image"
                    >
                    
                    <div v-if="isMyProfile" class="absolute top-4 right-4 hidden group-hover:block">
                        <button 
                            @click="triggerCoverUpload"
                            class="bg-white text-gray-800 px-3 py-1 rounded shadow text-sm font-bold flex items-center hover:bg-gray-100"
                        >
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 mr-2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6.827 6.175A2.31 2.31 0 015.186 7.23c-.38.054-.757.112-1.134.175C2.999 7.58 2.25 8.507 2.25 9.574V18a2.25 2.25 0 002.25 2.25h15A2.25 2.25 0 0021.75 18V9.574c0-1.067-.75-1.994-1.802-2.169a47.865 47.865 0 00-1.134-.175 2.31 2.31 0 01-1.64-1.055l-.822-1.316a2.192 2.192 0 00-1.736-1.039 48.774 48.774 0 00-5.232 0 2.192 2.192 0 00-1.736 1.039l-.821 1.316z" />
                            </svg>
                            Edit Cover
                        </button>
                        
                        <input 
                            type="file" 
                            id="coverInput" 
                            class="hidden"
                            @change="uploadCover"
                        >
                    </div>
                </div>

                <div class="px-6 pb-6 relative">
                    <div class="relative -mt-16 mb-4 flex justify-between items-end">
                        <div class="relative group">
                            <img 
                                :src="user.avatar_url" 
                                class="w-32 h-32 rounded-full border-4 border-white object-cover bg-gray-200"
                                alt="Avatar"
                            >
                            <div 
                                v-if="isMyProfile"
                                @click="triggerAvatarUpload"
                                class="absolute inset-0 bg-black/50 rounded-full flex items-center justify-center text-white opacity-0 group-hover:opacity-100 cursor-pointer transition"
                            >
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-8 h-8">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6.827 6.175A2.31 2.31 0 015.186 7.23c-.38.054-.757.112-1.134.175C2.999 7.58 2.25 8.507 2.25 9.574V18a2.25 2.25 0 002.25 2.25h15A2.25 2.25 0 0021.75 18V9.574c0-1.067-.75-1.994-1.802-2.169a47.865 47.865 0 00-1.134-.175 2.31 2.31 0 01-1.64-1.055l-.822-1.316a2.192 2.192 0 00-1.736-1.039 48.774 48.774 0 00-5.232 0 2.192 2.192 0 00-1.736 1.039l-.821 1.316z" />
                                </svg>
                                
                                <input 
                                    type="file" 
                                    id="avatarInput" 
                                    class="hidden"
                                    @change="uploadAvatar"
                                >
                            </div>
                        </div>

                        <div v-if="isMyProfile">
                            <button class="bg-gray-200 hover:bg-gray-300 text-gray-800 px-4 py-2 rounded font-semibold flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 mr-2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                                </svg>
                                Edit Profile
                            </button>
                        </div>
                    </div>

                    <h1 class="text-2xl font-bold text-gray-900">{{ user.name }}</h1>
                    <p class="text-gray-500 text-sm">@{{ user.username }}</p>
                </div>

                <div class="border-t border-gray-200 px-6">
                    <nav class="flex space-x-8" aria-label="Tabs">
                        <button 
                            v-for="tab in tabs" 
                            :key="tab"
                            @click="activeTab = tab"
                            :class="[
                                activeTab === tab 
                                ? 'border-indigo-500 text-indigo-600' 
                                : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300',
                                'whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm'
                            ]"
                        >
                            {{ tab }}
                        </button>
                    </nav>
                </div>
            </div>

            <div class="mt-6">
                <div v-if="activeTab === 'Posts'" class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="bg-white p-4 shadow rounded-lg h-fit">
                        <h2 class="font-bold text-lg mb-2">Intro</h2>
                        <p class="text-gray-600 text-sm">Developer at Laravel. Lives in Indonesia.</p>
                        <button class="w-full mt-3 bg-gray-100 py-2 rounded text-sm font-semibold">Edit Details</button>
                    </div>

                    <div class="md:col-span-2 space-y-4">
                        <div v-if="isMyProfile" class="bg-white p-4 shadow rounded-lg">
                            <input type="text" placeholder="What's on your mind?" class="w-full border-gray-300 rounded-full bg-gray-100 focus:ring-0">
                        </div>

                        <div class="bg-white p-4 shadow rounded-lg">
                            <p class="text-gray-800">Hello World! Ini adalah postingan pertama di profil ini.</p>
                            <div class="mt-4 h-48 bg-gray-200 rounded flex items-center justify-center text-gray-400">
                                [Image Placeholder]
                            </div>
                        </div>
                    </div>
                </div>

                <div v-if="activeTab === 'Photos'" class="bg-white p-6 shadow rounded-lg">
                    <h2 class="text-xl font-bold mb-4">Photos</h2>
                    <div class="grid grid-cols-3 gap-2">
                         <div class="bg-gray-200 h-32 rounded"></div>
                         <div class="bg-gray-200 h-32 rounded"></div>
                         <div class="bg-gray-200 h-32 rounded"></div>
                    </div>
                </div>

                <div v-if="activeTab === 'Followers'" class="bg-white p-6 shadow rounded-lg text-center text-gray-500">
                    List Followers will appear here.
                </div>
                <div v-if="activeTab === 'Followings'" class="bg-white p-6 shadow rounded-lg text-center text-gray-500">
                    List Followings will appear here.
                </div>

            </div>
        </div>
    </AuthenticatedLayout>
</template>