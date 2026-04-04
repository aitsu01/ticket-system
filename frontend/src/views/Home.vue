<template>
  <div class="min-h-screen bg-gray-100 flex flex-col">

    <!--  NAVBAR -->
    <div class="flex justify-between items-center p-4 bg-white shadow">
      <h1 class="font-bold text-lg">Ticket System</h1>

      <div class="flex gap-3">
        <router-link to="/" class="text-gray-600 hover:text-black">
          Home
        </router-link>

        <router-link to="/login" class="text-blue-500">
          Login
        </router-link>

        <router-link to="/register" class="bg-blue-500 text-white px-3 py-1 rounded">
          Register
        </router-link>
      </div>
    </div>

    <!--  HERO -->
    <div class="flex flex-1 items-center justify-center text-center px-4">
      <div class="max-w-xl">

        <h2 class="text-3xl font-bold mb-4">
          Manage your tickets efficiently
        </h2>

        <p class="text-gray-600 mb-6">
          A simple and powerful helpdesk system to track, manage and resolve support tickets with ease.
        </p>

        <div class="flex justify-center gap-4">
          <router-link
            to="/register"
            class="bg-blue-500 text-white px-6 py-2 rounded"
          >
            Get Started
          </router-link>

          <router-link
            to="/login"
            class="border px-6 py-2 rounded"
          >
            Login
          </router-link>
        </div>

      </div>
    </div>

    <!--  FEATURES -->
    <div class="bg-white py-10">
      <div class="max-w-4xl mx-auto grid grid-cols-1 md:grid-cols-3 gap-6 text-center">

        <div>
          <h3 class="font-bold mb-2">Ticket Management</h3>
          <p class="text-gray-500 text-sm">
            Create, track and manage support tickets easily.
          </p>
        </div>

        <div>
          <h3 class="font-bold mb-2">Assign Agents</h3>
          <p class="text-gray-500 text-sm">
            Assign tickets to team members and collaborate.
          </p>
        </div>

        <div>
          <h3 class="font-bold mb-2">Real-time Updates</h3>
          <p class="text-gray-500 text-sm">
            Stay updated with status changes and comments.
          </p>
        </div>

      </div>
    </div>

  </div>
</template>