<div id="theme-button" x-data="{ iconName: localStorage.getItem('theme') || 'sun' }" x-init="
        document.documentElement.classList.toggle('dark', iconName === 'moon');
        $watch('iconName', value => {
          document.documentElement.classList.toggle('dark', value === 'moon');
          localStorage.setItem('theme', value);
        });
      " class="rounded-full">
  <button @click="iconName = iconName === 'moon' ? 'sun' : 'moon'" class="p-2 rounded-full focus:outline-none" :class="{
          ' hover:bg-darkBg hover:text-darkText': iconName === 'sun',
          ' hover:bg-lightBg hover:text-lightText': iconName === 'moon',
        }">
    <template x-if="iconName === 'sun'">
      <x-forms.tw_icons name="moon" class="w-5 h-5" />
    </template>

    <template x-if="iconName === 'moon'">
      <x-forms.tw_icons name="sun" class="w-5 h-5" />
    </template>
  </button>
</div>