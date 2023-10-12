<script lang="ts" setup>
import { useDateMixin } from "~/mixins/dateMixin";
import { useAuthStore } from "~/stores/useAuthStore";

definePageMeta({
  middleware: ["auth"],
});

const auth = useAuthStore();

const { months, currentMonth, timeOfDay, currentYear } = useDateMixin();

interface SummaryItem {
  name: string;
  icon: string;
  amount: string;
}

type SummaryType = {
  total_income: number;
  total_expense: number;
  total_saving: number;
};

// Create a ref for the summary data
const summaryAmounts = ref<SummaryType>();

// Create a computed property for the summary items
const summaries = computed<SummaryItem[]>(() => {
  return summaryAmounts.value
    ? [
        {
          name: "Income",
          icon: "attach_money",
          amount: (summaryAmounts.value.total_income ?? "").toString(),
        },
        {
          name: "Expenses",
          icon: "shopping_cart_checkout",
          amount: (summaryAmounts.value.total_expense ?? "").toString(),
        },
        {
          name: "Savings",
          icon: "savings",
          amount: (summaryAmounts.value.total_saving ?? "").toString(),
        },
      ]
    : [];
});

onMounted(() => {
  getSummaryData();
});

// Fetch the summary data
async function getSummaryData() {
  await useApiFetch("/sanctum/csrf-cookie");

  const { data } = await useApiFetch(`/api/dash-summary`, {});

  summaryAmounts.value = data.value as SummaryType;
}

const assets = [
  {
    name: "Sacco Deposits",
    amount: "300000",
  },
  {
    name: "Branch Deposits",
    amount: "90000",
  },
  {
    name: "Sacco Share",
    amount: "30000",
  },
  {
    name: "Mali MMF",
    amount: "0",
  },
  {
    name: "Sanlam MMF",
    amount: "20000",
  },
];

const loans = [
  {
    name: "Bank",
    amount: "250000",
  },
  {
    name: "Mshwari",
    amount: "250000",
  },
  {
    name: "KCB Mpesa",
    amount: "250000",
  },
  {
    name: "David",
    amount: "250000",
  },
];

let activeTab = ref("assets");

const goals = [
  {
    title: "Come up with passive income ideas",
    done: true,
  },
  {
    title: "Have an emergency fund 300,000",
    done: false,
  },
  {
    title: "Save for holiday 70,000",
    done: false,
  },
  {
    title: "Join the gym",
    done: false,
  },
  {
    title: "Learn to swim",
    done: false,
  },
  {
    title: "Open a business",
    done: true,
  },
];
</script>

<template>
  <div>
    <h1 class="font-semibold text-xl mb-4 text-onyx-lighter">
      Good {{ timeOfDay }} {{ auth.user?.name }}!
    </h1>
    <p class="text-onyx-lightest mb-8">
      Here's summary of
      <span class="capitalize">{{ months[currentMonth] }}</span> budget
    </p>

    <!-- Amount Summary Cards -->
    <div class="flex items-center space-x-8 w-full mb-10">
      <dash-summary-card
        v-for="(summary, index) in summaries"
        :key="index"
        :summary="summary"
      />
    </div>

    <!-- Assets and Goals Cards -->
    <div class="flex items-start space-x-8">
      <div class="w-3/4">
        <div class="card">
          <!-- Assets Loans Tabs -->
          <div class="mb-4 border-b flex items-center justify-between">
            <ul class="flex items-center space-x-4">
              <li
                class="transition duration-100 cursor-pointer font-bold"
                :class="{
                  'border-b-2 border-primary text-primary':
                    activeTab == 'assets',
                  ' text-primary/50': activeTab != 'assets',
                }"
                @click="activeTab = 'assets'"
              >
                Assets
              </li>
              <li
                class="transition duration-100 cursor-pointer font-bold"
                :class="{
                  'border-b-2 border-primary text-primary font-bold':
                    activeTab == 'loans',
                  ' text-primary/50': activeTab != 'loans',
                }"
                @click="activeTab = 'loans'"
              >
                Loans
              </li>
            </ul>

            <p
              class="flex items-center text-xs text-primary/50 cursor-pointer hover:text-primary font-bold space-x-4"
            >
              Add Asset/Loan
              <span class="material-symbols-outlined text-sm ml-2">
                open_in_new
              </span>
            </p>
          </div>
          <!-- Tab content -->

          <div>
            <!-- Assets -->
            <asset-loan-view
              v-if="activeTab == 'assets'"
              :datum="assets"
              label="Assets"
            />
            <!-- Loans -->
            <asset-loan-view
              v-if="activeTab == 'loans'"
              :datum="loans"
              label="Loans"
            />
          </div>
        </div>
      </div>
      <div class="card w-1/3">
        <h4 class="font-semibold text-xl mb-4 text-onyx-lighter">
          Goals {{ currentYear }}
        </h4>

        <ul class="max-h-[350px] overflow-auto">
          <li
            class="pt-2 px-1 m-0 rounded transition duration-100 cursor-pointer hover:bg-gray-100 hover:text-primary text-onyx-lightest font-medium whitespace-nowrap"
            v-for="(goal, index) in goals"
            :key="index"
          >
            <span
              v-if="goal.done"
              class="material-symbols-outlined mr-2 text-primary"
            >
              check_circle
            </span>
            <span
              v-if="!goal.done"
              class="material-symbols-outlined mr-2 text-red-500"
            >
              cancel
            </span>
            <span class="w-full overflow-hidden text-ellipsis inline-block">
              {{ goal.title }}
            </span>
          </li>
        </ul>
      </div>
    </div>
  </div>
</template>
