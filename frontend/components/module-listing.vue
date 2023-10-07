<script setup>
const currentDate = new Date();
const currentMonth = currentDate.getMonth();
const currentYear = currentDate.getFullYear();

const months = [
  "jan",
  "feb",
  "mar",
  "apr",
  "may",
  "jun",
  "jul",
  "aug",
  "sept",
  "oct",
  "nov",
  "dec",
];

let activeMonth = ref(currentMonth);

const props = defineProps({
  name: String,
})

let modalActive = ref(false);

let moduleForm = ref({
  name: "",
  amount: "",
  month: "",
  errors: {},
});

const toggleModal = () => modalActive.value = !modalActive.value;

watch(modalActive, (value) => {
  if (!value) {
    moduleForm.value = {
      name: "",
      amount: "",
      month: "",
      errors: {},
    }
  }
})

let submittingForm = ref(false);

async function saveModule(form) {
  return await useApiFetch(`/api/${props.name}`, {
    method: 'POST',
    body: form,
  })
}

let moduleData = ref(null);

async function getModuleData() {
  await useApiFetch('/sanctum/csrf-cookie')

  const { data } = await useApiFetch(`/api/${props.name}`, {});

  moduleData.value = data.value.data;
}

let filteredModuleData = computed(() => {
    console.log(months[activeMonth.value]);
  return moduleData.value ? moduleData.value.filter((datum) => datum.month.startsWith(months[activeMonth.value])) : []
})

const handleConfirm = async () => {
  submittingForm.value = true;

  const { error } = await saveModule(moduleForm.value);

  if (!error.value) {
    toggleModal();
    getModuleData();
  };

  moduleForm.value.errors = error.value?.data.errors;

  submittingForm.value = false;
}

onMounted(() => {
  getModuleData();
})
</script>

<template>
  <div>
    <div class="mb-10">
      <div class="flex items-center justify-between mb-6">
        <h4 class="text-xl font-bold text-primary">
          {{ currentYear }}
        </h4>
        <button class="btn capitalize" @click="toggleModal">
          Add {{ name }} <span class="material-symbols-outlined"> add </span>
        </button>
      </div>

      <base-modal
        :title="'Add ' + name"
        :modal-active="modalActive"
        @close-modal="toggleModal"
        @confirm-modal="handleConfirm"
      >
        <div class="text-black">
          <p class="mb-4">Please fill the form below:</p>

          <!-- Module Form -->
          <div class="w-[500px]">
            <!-- Name Input -->
            <div class="mb-4">
              <icon-input
                :label="name + ' Name:'"
                v-model="moduleForm.name"
                id="name"
                placeholder="John Tyler"
                :error="moduleForm.errors.name"
              >
                <!-- icon -->
                {{
                  name == "income"
                    ? "attach_money"
                    : name == "expense"
                    ? "shopping_cart_checkout"
                    : "savings"
                }}
              </icon-input>
            </div>

            <!-- amount Input -->
            <div class="mb-4">
              <icon-input
                :label="name + ' Amount:'"
                v-model="moduleForm.amount"
                id="amount"
                type-val="number"
                placeholder="2000.00"
                :error="moduleForm.errors.amount"
              >
                <!-- icon -->
                monetization_on
              </icon-input>
            </div>

            <!-- Month Input -->
            <div class="mb-4">
              <month-picker
                :label="name + ' Month:'"
                v-model="moduleForm.month"
                id="month"
                placeholder="Select Month"
                :error="moduleForm.errors.month"
              ></month-picker>
            </div>
          </div>
        </div>
      </base-modal>

      <ul class="flex items-center justify-between">
        <li
          v-for="(month, index) in months"
          :key="month"
          class="uppercase cursor-pointer px-2 transition-all duration-100"
          :class="{
            'bg-primary text-white rounded-sm shadow-md': activeMonth == index,
            'font-medium text-gray-500': activeMonth != index,
          }"
          @click="activeMonth = index"
        >
          {{ month }}
        </li>
      </ul>
    </div>

    <div>
      <div class="flex items-center justify-center">
        <table
          class="min-w-full bg-white shadow-md rounded-lg overflow-hidden text-left"
        >
          <caption class="hidden text-lg font-semibold mb-2 text-left">
            {{
              months[activeMonth]
            }}
            Income Information
          </caption>
          <!-- Description -->
          <thead class="bg-primary text-white">
            <tr>
              <th class="py-2 px-4">Name</th>
              <th class="py-2 px-4">Amount</th>
              <th class="py-2 px-4">Month</th>
              <th class="py-2 px-4">Created</th>
              <th class="py-2 px-4">Action</th>
            </tr>
          </thead>
          <tbody>
            <tr
              class="mb-4"
              v-for="(datum, index) in filteredModuleData"
              :key="index"
            >
              <td class="py-6 px-4">{{ datum.name }}</td>
              <td class="py-6 px-4">{{ datum.amount }}</td>
              <td class="py-6 px-4">{{ datum.month }}</td>
              <td class="py-6 px-4">{{ datum.created_on }}</td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</template>

