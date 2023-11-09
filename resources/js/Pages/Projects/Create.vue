<template>
    <Head title="New Skill" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">New Skill</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <form @submit.prevent="submit">
                    <div>
                        <InputLabel for="name" value="Name" />

                        <TextInput
                            id="name"
                            type="text"
                            class="mt-1 block w-full"
                            v-model="form.name"
                            autofocus
                        />

                        <InputError class="mt-2" :message="form.errors.name" />
                    </div>

                    <div>
                        <InputLabel for="image" value="Image" />

                        <TextInput
                            id="image"
                            type="file"
                            class="mt-1 block w-full"
                            v-model="form.image"
                            @input="form.image = $event.target.files[0]"
                        />

                        <InputError class="mt-2" :message="form.errors.image" />
                    </div>

                    <div class="flex items-center justify-end mt-4">
                        <PrimaryButton class="ml-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                            Store
                        </PrimaryButton>
                    </div>
                </form>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
</script>
