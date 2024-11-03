<x-app-layout>
  <div class="flex content-between justify-between">
    <h2 class="font-extrabold">{{ __('Contacto') }}</h2>

  </div>
  <x-modal name="contactus"
           title="Contact Us Modal">
    <x-slot:body>
      <section class="bg-white dark:bg-gray-900">
        <div class="mx-auto max-w-screen-md px-4 py-8 lg:py-16">
          <h2 class="mb-4 text-center text-4xl font-extrabold tracking-tight text-gray-900 dark:text-white">Contact Us
          </h2>
          <p class="mb-8 text-center font-light text-gray-500 dark:text-gray-400 sm:text-xl lg:mb-16">Got a technical
            issue? Want to send feedback about a beta feature? Need details about our Business plan? Let us know.</p>
          <form class="space-y-8"
                action="#">
            <div>
              <label class="mb-2 block text-sm font-medium text-gray-900 dark:text-gray-300"
                     for="email">Your email</label>
              <input class="focus:ring-primary-500 focus:border-primary-500 dark:focus:ring-primary-500 dark:focus:border-primary-500 dark:shadow-sm-light block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 shadow-sm dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400"
                     id="email"
                     type="email"
                     placeholder="name@flowbite.com"
                     required>
            </div>
            <div>
              <label class="mb-2 block text-sm font-medium text-gray-900 dark:text-gray-300"
                     for="subject">Subject</label>
              <input class="focus:ring-primary-500 focus:border-primary-500 dark:focus:ring-primary-500 dark:focus:border-primary-500 dark:shadow-sm-light block w-full rounded-lg border border-gray-300 bg-gray-50 p-3 text-sm text-gray-900 shadow-sm dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400"
                     id="subject"
                     type="text"
                     placeholder="Let us know how we can help you"
                     required>
            </div>
            <div class="sm:col-span-2">
              <label class="mb-2 block text-sm font-medium text-gray-900 dark:text-gray-400"
                     for="message">Your message</label>
              <textarea class="focus:ring-primary-500 focus:border-primary-500 dark:focus:ring-primary-500 dark:focus:border-primary-500 block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 shadow-sm dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400"
                        id="message"
                        rows="6"
                        placeholder="Leave a comment..."></textarea>
            </div>
            <button class="bg-primary-700 hover:bg-primary-800 focus:ring-primary-300 dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800 rounded-lg px-5 py-3 text-center text-sm font-medium text-white focus:outline-none focus:ring-4 sm:w-fit"
                    type="submit">Send message</button>
          </form>
        </div>
      </section>
    </x-slot>
  </x-modal>

  <button class="rounded bg-blue-500 px-3 py-1 text-xs text-white"
          x-data
          @click="$dispatch('open-modal',{name:'contactus'})"> Modal 2 </button>

</x-app-layout>
