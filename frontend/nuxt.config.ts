// https://nuxt.com/docs/api/configuration/nuxt-config
export default defineNuxtConfig({
	runtimeConfig: {
		public: {
			appUrl: process.env.APP_URL ?? 'http://localhost:3000',
			apiUrl: process.env.API_URL ?? 'http://localhost:8000',
		},
	},

	devtools: { enabled: true },

	modules: ['@pinia/nuxt', '@nuxtjs/tailwindcss'],

	app: {
		head: {
			title: 'Budget Buddy',
			meta: [
				{
					name: 'description',
					content:
						'BudgetBuddy: Your trusted financial companion for effortless budgeting, helping you save money, track expenses, and achieve your financial goals with ease.',
				},
			],
			link: [
				{
					rel: 'stylesheet',
					href: 'https://fonts.googleapis.com/icon?family=Material+Symbols+Outlined',
				},
			],
		},
	},
})
