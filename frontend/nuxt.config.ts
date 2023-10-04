// https://nuxt.com/docs/api/configuration/nuxt-config
export default defineNuxtConfig({
	runtimeConfig: {
		public: {
			appUrl: process.env.APP_URL ?? 'http://localhost:3000',
			apiUrl: process.env.API_URL ?? 'http://localhost:8000',
		},
	},
	devtools: { enabled: true },
	modules: ['@pinia/nuxt'],
})
