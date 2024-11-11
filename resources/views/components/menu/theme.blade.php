<div id="theme-button" x-data="{ iconName: localStorage.getItem('theme') || 'sun' }" x-init="
        document.documentElement.classList.toggle('dark', iconName === 'moon');
        $watch('iconName', value => {
          document.documentElement.classList.toggle('dark', value === 'moon');
          localStorage.setItem('theme', value);
        });
      " class="rounded-full">
  <button @click="iconName = iconName === 'moon' ? 'sun' : 'moon'" class="p-1 rounded-full text-xs focus:outline-none"
    :class="{
          ' hover:bg-darkBg hover:text-darkText': iconName === 'sun',
          ' hover:bg-lightBg hover:text-lightText': iconName === 'moon',
        }">
    <template x-if="iconName === 'sun'">
      <x-forms.tw_icons name="moon" class="w-3 h-3" />
    </template>

    <template x-if="iconName === 'moon'">
      <x-forms.tw_icons name="sun" class="w-3 h-3" />
    </template>
  </button>
</div>