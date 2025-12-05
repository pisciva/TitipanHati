'use client'

import { useState } from 'react'
import { useForm } from 'react-hook-form'
import { InputField } from '@/components/auth/FormInput'
import { useRouter, useSearchParams } from 'next/navigation'
import Link from 'next/link'
import axios from 'axios'
import '@/components/auth/auth.css'
import Toast from '@/components/layouts/Toast'

export default function ResetPass() {
    const { register, handleSubmit, formState: { errors } } = useForm<{ password: string; confirmPassword: string }>()
    const [serverError, setServerError] = useState('')
    const [serverMessage, setServerMessage] = useState('')
    const [showPassword, setShowPassword] = useState(false)
    const [loading, setLoading] = useState(false)
    const [cooldown, setCooldown] = useState(0)

    const token = useSearchParams().get('token')
    const router = useRouter()

    const onSubmit = async (data: { password: string; confirmPassword: string }) => {
        setServerError(''); setServerMessage('')

        if (!token) return setServerError('Missing token in URL')
        if (data.password !== data.confirmPassword) return setServerError('Passwords do not match')

        try {
            // const res = await axios.post('http://localhost:5000/reset-password', { token, password: data.password })
            // setServerMessage(res.data.message || 'Password reset successful.')
            // setTimeout(() => router.push('/login'), 2000)
        } catch (err: any) {
            setServerError(err.response?.data?.message || err.message || 'Reset failed.')
        }
    }

    const passwordFieldProps = (name: 'password' | 'confirmPassword', placeholder: string) => ({
        type: 'password',
        icon: '/icon-padlock.svg',
        placeholder,
        register,
        name,
        rules: { required: `${placeholder} is required`, minLength: { value: 6, message: 'Minimum 6 characters' } },
        showPasswordToggle: true,
        showPassword,
        setShowPassword,
        error: errors[name]?.message
    })

    return (
        <div className="min-h-screen flex flex-col items-center justify-center bg-white relative">
            <img src="/Logo.svg" alt="" className='absolute top-30 w-64' />

            <div className="w-full lg:max-w-150 max-w-120 bg-white lg:bg-white rounded-2xl px-18 py-12 relative border">

                <h1 className="text-2xl lg:text-3xl font-bold text-center mb-4">Atur Ulang Kata Sandi</h1>
                <h1 className="text-sm lg:text-md font-medium text-[#64748B] text-center mb-6">
                    Silakan masukkan kata sandi baru Anda di bawah ini.
                </h1>

                <form onSubmit={handleSubmit(onSubmit)} className="flex flex-col justify-center items-center w-full">
                    <div className='w-full'>
                        <InputField {...passwordFieldProps('password', 'Masukkan Kata Sandi kamu')} />
                        <InputField {...passwordFieldProps('confirmPassword', 'Konfirmasi Kata Sandi kamu')} />
                    </div>
                    <button
                        type="submit"
                        disabled={loading || cooldown > 0}
                        className={`bg-[#FF4400] hover:bg-[#EB3F00] px-12 py-3 rounded-full text-white text-lg font-semibold mt-8 cursor-pointer w-48 flex justify-center items-center
                            ${loading
                                ? 'bg-[#F59E0B] cursor-not-allowed hover:cursor-not-allowed'
                                : cooldown > 0
                                    ? 'bg-[#334155] cursor-not-allowed hover:cursor-not-allowed'
                                    : 'bg-[#0054A5] hover:bg-[#034691] focus:bg-[#EB3F00]'
                            }`}
                    >
                        {loading
                            ? 'Processing...'
                            : cooldown > 0
                                ? `Wait ${cooldown}s`
                                : 'Atur Ulang'}
                    </button>
                </form>
            </div>

            <Link href={"/login"} className='absolute left-30 bottom-15 flex gap-2 cursor-pointer'>
                <img src="/icon-back.svg" alt="" />
                <p className='text-[#FF4400] font-semibold text-lg'>Kembali</p>
            </Link>

            {serverMessage && <Toast message={serverMessage} type="success" onClose={() => setServerMessage('')} />}
            {serverError && <Toast message={serverError} type="error" onClose={() => setServerError('')} />}
        </div>
    )
}
