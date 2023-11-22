<script setup>
import numeral from 'numeral';
import { useDateStore } from '~/stores/useDateStore';

const date = useDateStore();

const {
  intent,
  message,
  showSuccessAlert,
  showDangerAlert,
  toggleSuccessAlert,
  toggleDangerAlert,
} = useAlert();

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
  month: date.activeMonth,
  errors: {},
});

// Toggle Manage Module Modal
const toggleModal = () => {
  activeRecord.value = {}
  moduleForm.value.month = ''//todo:: activeMonth.value >= currentMonth ? months[activeMonth.value] : months[currentMonth]
  modalActive.value = !modalActive.value
};

// Toggle Delete Module Modal
const toggleDelModal = (datum = null) => {
  if (datum) activeRecord.value = datum;
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
  return moduleData.value ? moduleData.value.filter((datum) => datum.month.startsWith(date.months[activeMonth.value])) : []
});

let getTotalValue = computed(() => {
  return filteredModuleData.value.reduce((total, item) => total + item.amount, 0);
})

// Handle the delete action
const handleDeleteConfirm = async () => {
  const { data, error } = await deleteModule(activeRecord.value);

  if (!error.value) {
    toggleDangerAlert(data.value.message);
    toggleDelModal();
    getModuleData();
  };
};

// Handle create/edit actions
const handleConfirm = async () => {
  submittingForm.value = true;

  const { data, error } = await saveModule(moduleForm.value);

  if (!error.value) {
    toggleSuccessAlert(data.value.message);
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
    <!-- Alerts -->
    <alert
      :intent="intent"
      :message="message"
      title="Success Alert"
      :show="showSuccessAlert"
      :on-dismiss="() => toggleSuccessAlert()"
    />

    <alert
      :intent="intent"
      :message="message"
      title="Danger Alert"
      :show="showDangerAlert"
      :on-dismiss="() => toggleDangerAlert()"
    />
    <!-- End of alerts -->

    <div>
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
                :current-month="date.currentMonth"
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

      <div class="">
        <div class="flex items-center justify-between py-4 mb-3">
          <h1 class="text-90 font-normal text-2xl capitalize">
            {{ date.activeMonth }} {{ name }}
          </h1>

          <div
            :title="'Create' + name"
            class="capitalize cursor-pointer btn btn-default btn-primary bg-primary hover:bg-primary/90 font-bold"
            @click="toggleModal"
          >
            Create {{ name }}
          </div>
        </div>
      </div>
    </div>

    <div>
      <div class="flex items-center justify-center">
        <div
          v-if="filteredModuleData.length == 0"
          class="text-center w-full bg-white rounded overflow-hidden py-20 shadow-md"
        >
          <div class="mb-3">
            <span class="material-symbols-outlined text-6xl text-onyx-lightest">
              data_table
            </span>
          </div>
          <p class="text-base text-80 font-normal mb-6 text-onyx-lightest">
            No {{ name }} matched the given criteria for
            <span class="">{{ date.activeMonth }}</span>
          </p>
        </div>
        <table
          v-else
          class="min-w-full bg-white shadow-md rounded overflow-hidden text-left"
        >
          <caption class="hidden text-lg font-semibold mb-2 text-left">
            {{
              date.months[activeMonth]
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
            <tr>
              <td class="py-6 px-4"></td>
              <td class="py-6 px-4">
                <p class="font-bold">Total</p>
              </td>
              <td class="py-6 px-4">
                <p class="font-bold">
                  KES {{ formattedNumber(getTotalValue) }}
                </p>
              </td>
              <td class="py-6 px-4">
                <p class="font-bold">{{ currentDateTime }}</p>
              </td>
              <td class="py-6 px-4">
                <p class="font-bold">{{ currentDateTime }}</p>
              </td>
              <td class="py-6 px-4"></td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</template>

