export function useAlert<T>() {
	let intent = ref<'info' | 'success' | 'warning' | 'danger'>('success')
	let alertMessage = ref<string>('')

	let showInfoAlert = ref(false)
	let showSuccessAlert = ref(false)
	let showWarningAlert = ref(false)
	let showDangerAlert = ref(false)

	const toggleInfoAlert = (message: string = '') => {
		alertMessage.value = message
		intent.value = 'info'
		showInfoAlert.value = !showInfoAlert.value
	}

	const toggleSuccessAlert = (message: string = '') => {
		alertMessage.value = message
		intent.value = 'success'
		showSuccessAlert.value = !showSuccessAlert.value
	}

	const toggleWarningAlert = (message: string = '') => {
		alertMessage.value = message
		intent.value = 'warning'
		showWarningAlert.value = !showWarningAlert.value
	}

	const toggleDangerAlert = (message: string = '') => {
		alertMessage.value = message
		intent.value = 'danger'
		showDangerAlert.value = !showDangerAlert.value
	}

	let message = computed(() => alertMessage.value)

	return {
		intent,
		message,
		showInfoAlert,
		showSuccessAlert,
		showWarningAlert,
		showDangerAlert,
		toggleInfoAlert,
		toggleSuccessAlert,
		toggleWarningAlert,
		toggleDangerAlert,
	}
}
