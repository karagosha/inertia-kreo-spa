<script setup>
import {ref} from 'vue';
import BreezeApplicationLogo from '@/Components/ApplicationLogo.vue';
import BreezeNavLink from '@/Components/NavLink.vue';
import BreezeResponsiveNavLink from '@/Components/ResponsiveNavLink.vue';
import {Link} from '@inertiajs/inertia-vue3';

const showingNavigationDropdown = ref(false);
</script>

<template>
    <nav class="bg-gray-100 border-b border-gray-100">
        <!-- Primary Navigation Menu -->
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex">
                    <!-- Logo -->
                    <div class="shrink-0 flex items-center">
                        <Link :href="route('home')">
                            <BreezeApplicationLogo class="block h-9 w-auto"/>
                        </Link>
                    </div>

                    <!-- Navigation Links -->
                    <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                        <BreezeNavLink :href="route('base.projects.index')" class="text-gray-800"
                                       :active="route().current('base.projects.index')">
                            Проекты
                        </BreezeNavLink>
                        <BreezeNavLink :href="route('base.job.index')" class="text-gray-800"
                                       :active="route().current('base.job.index')">
                            Вакансии
                        </BreezeNavLink>
<!--                        <BreezeNavLink :href="route('base.employees.index')" class="text-gray-800"-->
<!--                                       :active="route().current('base.employees.index')">-->
<!--                            Команда-->
<!--                        </BreezeNavLink>-->
<!--                        <BreezeNavLink :href="route('base.feedback.index')" class="text-gray-800"-->
<!--                                       :active="route().current('base.feedback.index')">-->
<!--                            Отзывы-->
<!--                        </BreezeNavLink>-->
                    </div>
                </div>

                <!-- Hamburger -->
                <div class="-mr-2 flex items-center sm:hidden">
                    <button @click="showingNavigationDropdown = ! showingNavigationDropdown"
                            class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                        <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                            <path
                                :class="{'hidden': showingNavigationDropdown, 'inline-flex': ! showingNavigationDropdown }"
                                stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6h16M4 12h16M4 18h16"/>
                            <path
                                :class="{'hidden': ! showingNavigationDropdown, 'inline-flex': showingNavigationDropdown }"
                                stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        <!-- Responsive Navigation Menu -->
        <div :class="{'block': showingNavigationDropdown, 'hidden': ! showingNavigationDropdown}" class="sm:hidden">
            <div class="pt-2 pb-3 space-y-1">
                <BreezeResponsiveNavLink :href="route('projects.index')" :active="route().current('projects.index')">
                    Проекты
                </BreezeResponsiveNavLink>
            </div>
        </div>
    </nav>
</template>
