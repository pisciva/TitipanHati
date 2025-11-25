'use client'

import { useState } from 'react'
import { useForm } from 'react-hook-form'
import { InputField } from '@/components/auth/FormInput'
import axios from 'axios'
import Link from 'next/link'
import Toast from '@/components/layouts/Toast'
import RightCol from '@/components/auth/RightCol'
import OAuth from '@/components/auth/OAuth'
import '@/components/auth/auth.css'
import '@/app/globals.css'
    
type FormValues = { email: string; password: string }

export default function LoginPage() {
    const [serverError, setServerError] = useState('')
    const [showPassword, setShowPassword] = useState(false)

    const {
        register,
        handleSubmit,
        formState: { errors }
    } = useForm<FormValues>()

    const onSubmit = async (data: FormValues) => {
        setServerError('')
        try {
            const res = await axios.post('http://localhost:5000/auth/login', data)
            window.location.href = `http://localhost:3000?token=${res.data.token}`
        } catch (err: any) {
            setServerError(err.response?.data?.message || 'Login failed')
        }
    }

    return (
        <div className="bg-[#F8FAFC] h-screen overflow-hidden grid grid-cols-2 justify-items-center items-center">
            <div className="w-full rounded-lg bg-[#F8FAFC] p-24">
                <img src="/Logo.svg" alt="" className='w-48 mb-24' />

                <form onSubmit={handleSubmit(onSubmit)} className="space-y-2">
                    <div className="font-bold text-4xl mb-8">
                        Halo, <br /> Selamat Datang Kembali!
                    </div>

                    <InputField
                        label='Email'
                        icon="/icon-email.svg"
                        placeholder="Masukkan email kamu"
                        register={register}
                        name="email"
                        rules={{ required: 'Email is required' }}
                        error={errors.email?.message} />

                    <InputField
                        label='Kata Sandi'
                        type="password"
                        icon="/icon-padlock.svg"
                        placeholder="Masukkan kata sandi kamu"
                        register={register}
                        name="password"
                        rules={{ required: 'Password is required' }}
                        showPasswordToggle
                        showPassword={showPassword}
                        setShowPassword={setShowPassword}
                        error={errors.password?.message} />

                    <div className="mt-4 flex justify-between">
                        <Link href="/forgot-password" className="text-[#626262] font-bold hover:underline font-semibold">Lupa Kata Sandi?</Link>

                        <div className="text-[#626262] font-bold font-semibold">Belum memiliki akun? {''}
                            <Link href="/register" className='text-[#FF4400] hover:underline'>
                                Buat akun disini
                            </Link>
                        </div>
                    </div>

                    {serverError && <Toast message={serverError} type="error" onClose={() => setServerError('')} />}

                    <button type="submit" className="bg-[#FF4400] hover:bg-[#EB3F00] px-12 py-3 rounded-full text-white text-lg font-semibold mt-8 mb-4 cursor-pointer">Masuk</button>
                </form>

                <OAuth />
            </div>

            <RightCol />
        </div>
    )
}
