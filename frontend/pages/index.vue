<script lang="ts" setup>
import { useDateMixin } from "~/mixins/dateMixin";
import { useAuthStore } from "~/stores/useAuthStore";

definePageMeta({
  middleware: ["auth"],
});

const auth = useAuthStore();

const { months, currentMonth, timeOfDay, currentYear } = useDateMixin();

const summaries = [
  {
    name: "Income",
    amount: "200000",
    icon: "attach_money",
  },
  {
    name: "Expense",
    amount: "100000",
    icon: "shopping_cart_checkout",
  },
  {
    name: "Saving",
    amount: "90000",
    icon: "savings",
  },
];

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
      <div class="card w-1/3">Goals {{ currentYear }}</div>
    </div>
  </div>
</template>
