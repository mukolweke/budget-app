import type { UseFetchOptions } from 'nuxt/app'
import { useRequestHeaders } from 'nuxt/app'

export function useApiFetch<T>(path: string, options: UseFetchOptions<T> = {}) {
	const config = useRuntimeConfig()

	let headers: any = {
		accept: 'application/json',
		referer: config.public.appUrl,
	}

	const token = useCookie('XSRF-TOKEN')

	if (token.value) {
		headers['X-XSRF-TOKEN'] = token.value
	}

	if (process.server) {
		headers = {
			...headers,
			...useRequestHeaders(['cookie']),
		}
	}

	return useFetch(config.public.apiUrl + path, {
		credentials: 'include',
		watch: false,
		...options,
		headers: {
			...headers,
			...options?.headers,
		},
	})
}
