<template>
    <Head title="New Project" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">New Project</h2>
        </template>

        <div class="py-12">
            <div class="max-w-md mx-auto sm:px-6 lg:px-8 bg-white">
                <form class="p-4" @submit.prevent="submit">

                    <!-- Select input field -->
                    <div>
                        <InputLabel for="skill_id" value="Skill" />
                        <select v-model="form.skill_id" id="skill_id" name="skill_id"
                            class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 rounded-md">
                            <option v-for="skill in skills?.length ? skills : []" :key="skill.id" :value="skill.id"> {{ skill.name }}</option>
                        </select>
                    </div>

                    <!-- Name input field -->
                    <div>
                        <InputLabel for="name" value="Name" />

                        <TextInput id="name" type="text" class="mt-1 block w-full" v-model="form.name"
                            autocomplete="name" />

                        <InputError class="mt-2" :message="form.errors?.name" />
                    </div>

                    <!-- URL input field -->
                    <div>
                        <InputLabel for="project_url" value="URL" />

                        <TextInput id="project_url" type="text" class="mt-1 block w-full" v-model="form.project_url"
                            autocomplete="project_url" />

                        <InputError class="mt-2" :message="form.errors?.project_url" />
                    </div>

                    <!-- Image upload field -->
                    <div class="mt-2">
                        <InputLabel for="image" value="Image" />
                        <TextInput id="image" type="file" class="mt-1 block w-full" v-model="form.image" />
                        <InputError class="mt-2" :message="form.errors?.image" />
                    </div>

                    <!-- Store button field -->
                    <div class="flex items-center justify-end mt-4">
                        <PrimaryButton class="ml-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                            Update
                        </PrimaryButton>
                    </div>

                </form>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { router } from '@inertiajs/vue3'

const props = defineProps({
    skills: Array,
    project: Object
});

const form = useForm({
    name: props.project?.name,
    image: null,
    skill_id: props.project?.skill_id,
    project_url: props.project?.project_url,
});

const submit = async () => {
    try {
        await router.post(`/projects/${props.project.id}`, {
            _method: 'put',
            name: form.name,
            image: form.image,
            skill_id: form.skill_id,
            project_url: form.project_url,
        });

        router.push({ name: 'projects.index' });
    } catch (error) {
        console.error(error);
    }
};
</script>
