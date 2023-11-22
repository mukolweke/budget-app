interface SummaryType {
	total_income: number
	total_expense: number
	total_saving: number
}

function isSummaryType(obj: any): obj is SummaryType {
	return (
		typeof obj === 'object' &&
		'total_income' in obj &&
		'total_expense' in obj &&
		'total_saving' in obj
	)
}

export function useSummary<T>() {
	const summaryAmounts = ref<SummaryType>({
		total_income: 0,
		total_expense: 0,
		total_saving: 0,
	})

	// let balance = ref<number>(0)

	function calculateBalance() {
		return (
			summaryAmounts.value.total_income -
			(summaryAmounts.value.total_expense + summaryAmounts.value.total_saving)
		)
	}

	const balance = computed(() => {
		return calculateBalance()
	})

	async function getSummaryData(month: string) {
		await useApiFetch('/sanctum/csrf-cookie')

		try {
			const { data } = await useApiFetch(`/api/dash-summary?month=${month}`, {})

			if (isSummaryType(data.value)) {
				summaryAmounts.value = data.value
				// balance.value = calculateBalance()
			} else {
				console.error('Invalid summary data received:', data)
			}
		} catch (error) {
			console.error('Error fetching summary data:', error)
		}
	}

	return {
		summaryAmounts,
		balance,
		getSummaryData,
	}
}
