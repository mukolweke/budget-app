<script setup>
const currentDate = new Date();
const currentMonth = currentDate.getMonth();
const currentYear = currentDate.getFullYear();

const months = [
  "Jan",
  "Feb",
  "Mar",
  "Apr",
  "May",
  "Jun",
  "Jul",
  "Aug",
  "Sept",
  "Oct",
  "Nov",
  "Dec",
];

let activeMonth = ref(currentMonth);

const props = defineProps({
  name: String,
})

let modalActive = ref(false);

const toggleModal = () => (modalActive.value = !modalActive.value);

const moduleForm = ref({
  name: "",
  amount: "",
  module: props.name,
  month: "",
  errors: {
    name: "",
    amount: "",
  },
});

const handleConfirm = () => {
    console.log('moduleForm', moduleForm.value);
}
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
            </tr>
          </thead>
          <tbody>
            <tr class="mb-4">
              <td class="py-2 px-4">John Doe</td>
              <td class="py-2 px-4">30</td>
            </tr>
            <tr class="mb-4">
              <td class="py-2 px-4">Jane Smith</td>
              <td class="py-2 px-4">25</td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</template>

