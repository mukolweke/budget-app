<script setup>
import numeral from 'numeral';
import { useDateMixin } from "~/mixins/dateMixin";

const { months, currentMonth, currentYear, activeMonth } = useDateMixin();

let activeRecord = ref({});

const props = defineProps({
  name: String,
})

let modalActive = ref(false);
let modalDelActive = ref(false);

// Form To Create/Edit Module(Income, Savings, Expenses)
let moduleForm = ref({
  name: "",
  amount: "",
  month: months[activeMonth.value],
  errors: {},
});

// Toggle Manage Module Modal
const toggleModal = () => {
  activeRecord.value = {}
  moduleForm.value.month = activeMonth.value >= currentMonth ? months[activeMonth.value] : months[currentMonth]
  modalActive.value = !modalActive.value
};

// Toggle Delete Module Modal
const toggleDelModal = (datum) => {
  activeRecord.value = datum;
  modalDelActive.value = !modalDelActive.value
};

// Toggle Edit Module Modal - Setting values
const toggleEditModal = (datum) => {
  activeRecord.value = datum;
  moduleForm.value.id = datum.id;
  moduleForm.value.name = datum.name;
  moduleForm.value.salary = datum.salary;
  moduleForm.value.amount = datum.amount;
  moduleForm.value.month = datum.month;
  modalActive.value = !modalActive.value
};

// Reset the form values
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

// Saving/Update module method
async function saveModule(form) {
  await useApiFetch('/sanctum/csrf-cookie');

  let url = form.id ? `/api/${props.name}/${form.id}` : `/api/${props.name}`;

  return await useApiFetch(url, {
    method: form.id ? 'PATCH' : 'POST',
    body: form,
  });
}

// Delete module method
async function deleteModule(record) {
  await useApiFetch('/sanctum/csrf-cookie');

  return await useApiFetch(`/api/${props.name}/${record.id}`, {
    method: 'DELETE',
  });
}

let moduleData = ref(null);
let fetchingData = ref(false);

// Fetch the module data/listing
async function getModuleData() {
  fetchingData.value = true;
  await useApiFetch('/sanctum/csrf-cookie')

  const { data } = await useApiFetch(`/api/${props.name}`, {});

  moduleData.value = data.value.data;
  fetchingData.value = false;
}

// Filter out the data when listing by active month
let filteredModuleData = computed(() => {
  return moduleData.value ? moduleData.value.filter((datum) => datum.month.startsWith(months[activeMonth.value])) : []
})

// Handle the delete action
const handleDeleteConfirm = async () => {
  const { error } = await deleteModule(activeRecord.value);

  if (!error.value) {
    toggleDelModal();
    getModuleData();
  };
};

// Handle create/edit actions
const handleConfirm = async () => {
  submittingForm.value = true;

  const { error } = await saveModule(activeRecord.value);

  if (!error.value) {
    toggleModal();
    getModuleData();
  };

  moduleForm.value.errors = error.value?.data.errors;

  submittingForm.value = false;
}

const formattedNumber = (amount) => {
  return numeral(amount).format('0,0.00');
}

onMounted(() => {
  getModuleData();
})
</script>

<template>
  <div>
    <div class="mb-10">
      <base-modal
        :title="(activeRecord.id ? 'Edit ' : 'Add ') + name"
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
                :current-month="currentMonth"
                v-model="moduleForm.month"
                id="month"
                placeholder="Select Month"
                :error="moduleForm.errors.month"
              ></month-picker>
            </div>
          </div>
        </div>
      </base-modal>

      <!-- Delete Modal -->
      <base-modal
        title=""
        :modal-active="modalDelActive"
        @close-modal="modalDelActive = !modalDelActive"
        hide-buttons
      >
        <div
          class="flex flex-col items-center justify-center space-y-8 max-w-md mx-auto text-center text-onyx-lighter"
        >
          <span class="material-symbols-outlined text-8xl text-red-500">
            cancel
          </span>

          <h2 class="font-semibold text-3xl">Are you sure?</h2>

          <p>
            Do you really want to delete these {{ name }} record? This process
            cannot be undone.
          </p>

          <div class="flex items-center space-x-4">
            <button
              class="btn-cancel px-10 py-2.5"
              @click="modalDelActive = !modalDelActive"
            >
              Cancel
            </button>
            <button
              class="btn-danger px-10 py-2.5"
              @click="handleDeleteConfirm"
            >
              Delete
            </button>
          </div>
        </div>
      </base-modal>

      <div class="border-2 border-primary rounded shadow">
        <div class="flex items-center justify-between bg-primary p-4">
          <p class="text-sm text-white font-bold capitalize">
            {{ currentYear }}
          </p>

          <div
            title="Create"
            class="capitalize cursor-pointer text-sm text-white font-bold flex items-center"
            @click="toggleModal"
          >
            Add {{ name }} <span class="material-symbols-outlined"> add </span>
          </div>
        </div>
        <ul
          class="grid grid-cols-3 lg:grid-cols-6 grid-rows-3 lg:grid-rows-2 gap-4 p-1"
        >
          <li
            v-for="(month, index) in months"
            :key="month"
            class="uppercase cursor-pointer px-4 mx-auto transition-all duration-100"
            :class="{
              'bg-primary text-white rounded-sm shadow-md':
                activeMonth == index,
              'font-medium text-gray-500': activeMonth != index,
            }"
            @click="activeMonth = index"
            :title="month"
          >
            {{ month }}
          </li>
        </ul>
      </div>
    </div>

    <div>
      <div class="flex items-center justify-center">
        <div v-if="filteredModuleData.length == 0" class="text-2xl">
          No {{ name }} records for
          <span class="capitalize">{{ months[activeMonth] }}</span>
        </div>
        <table
          v-else
          class="min-w-full bg-white shadow-md rounded overflow-hidden text-left"
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
              <th class="py-2 px-4">#</th>
              <th class="py-2 px-4">Name</th>
              <th class="py-2 px-4">Amount</th>
              <th class="py-2 px-4">Created</th>
              <th class="py-2 px-4">Updated</th>
              <th class="py-2 px-4">Action</th>
            </tr>
          </thead>
          <tbody>
            <tr
              class="mb-4"
              v-for="(datum, index) in filteredModuleData"
              :key="index"
            >
              <td class="py-6 px-4">{{ index + 1 }}</td>
              <td class="py-6 px-4">{{ datum.name }}</td>
              <td class="py-6 px-4">KES {{ formattedNumber(datum.amount) }}</td>
              <td class="py-6 px-4">{{ datum.created_on }}</td>
              <td class="py-6 px-4">{{ datum.updated_on }}</td>
              <td>
                <div class="flex items-center space-x-4">
                  <span
                    title="Edit"
                    @click="toggleEditModal(datum)"
                    class="w-5 h-5 rounded-full material-symbols-outlined text-blue-500 cursor-pointer"
                  >
                    edit
                  </span>

                  <span
                    title="Delete"
                    @click="toggleDelModal(datum)"
                    class="w-5 h-5 rounded-full material-symbols-outlined text-red-500 cursor-pointer"
                  >
                    delete
                  </span>
                </div>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</template>

