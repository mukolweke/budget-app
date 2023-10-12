import { ref } from 'vue'
import { format } from 'date-fns'

export function useDateMixin() {
	const currentDate = new Date()
	const currentMonth = currentDate.getMonth()
	const currentYear = currentDate.getFullYear()

	const months = [
		'january',
		'february',
		'march',
		'april',
		'may',
		'june',
		'july',
		'august',
		'september',
		'october',
		'november',
		'december',
	]

	let activeMonth = ref(currentMonth)

	const timeOfDay = computed(() => {
		const currentHour = currentDate.getHours()
		if (currentHour >= 6 && currentHour < 12) {
			return 'Morning'
		} else if (currentHour >= 12 && currentHour < 17) {
			return 'Afternoon'
		} else {
			return 'Evening'
		}
	})

	const currentDateTime = format(currentDate, 'dd, MMM yyyy hh:mm a')

	return {
		currentMonth,
		months,
		currentYear,
		activeMonth,
		timeOfDay,
		currentDateTime,
	}
}
