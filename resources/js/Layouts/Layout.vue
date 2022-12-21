<script setup>
import AdminNav from "@/Layouts/AdminNav";
import Navigation from "@/Layouts/Navigation";

</script>

<template>
    <AdminNav v-if="$page.props.auth.isAdmin"></AdminNav>
    <Navigation></Navigation>
    <!-- Page Content -->
    <div class="min-h-screen flex flex-col bg-gray-100">
        <div class="w-2/3 mt-5 mx-auto bg-white">
            <slot/>
        </div>
    </div>

    <!-- Page Heading -->
    <!--    <header class="bg-white shadow" v-if="$slots.header">-->
    <!--        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">-->
    <!--            <slot name="header"/>-->
    <!--        </div>-->
    <!--    </header>-->

    <!-- Page Content -->
    <!--    <main class="max-w-7xl mx-auto">-->
    <!--        <slot/>-->
    <!--    </main>-->
</template>
