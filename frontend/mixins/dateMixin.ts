import { ref } from 'vue'
import { format } from 'date-fns'

export function useDateMixin() {
	const currentDate = new Date()
	const currentMonth = ref(currentDate.getMonth());
	
	const currentYear = currentDate.getFullYear()

	const months = [
		'jan',
		'feb',
		'mar',
		'apr',
		'may',
		'jun',
		'jul',
		'aug',
		'sept',
		'oct',
		'nov',
		'dec',
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

	const updateCurrentMonth = (month: number) => {
		currentMonth.value = month // Update the value of the reactive reference
	}

	return {
		currentMonth,
		months,
		currentYear,
		activeMonth,
		timeOfDay,
		currentDateTime,
		updateCurrentMonth,
	}
}
