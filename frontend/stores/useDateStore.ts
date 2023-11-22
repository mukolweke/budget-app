// store/dateStore.ts
import { defineStore } from 'pinia'
import { ref, computed } from 'vue'
import { format } from 'date-fns'

export const useDateStore = defineStore('date', () => {
	const currentDate = new Date()
	let currentMonth = ref<number>(new Date().getMonth())
	const currentYear = new Date().getFullYear()
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

    let activeMonth = ref<string>(months[currentMonth.value])

	const updateCurrentMonth = (month: number) => {
		currentMonth.value = month // /index
		activeMonth.value = months[currentMonth.value] // name
    }

	return {
		months,
		currentMonth,
		activeMonth,
		currentYear,
		timeOfDay,
		currentDateTime,
		updateCurrentMonth,
	}
})
