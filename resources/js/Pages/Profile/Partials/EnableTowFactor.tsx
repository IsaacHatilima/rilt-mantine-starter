import { useForm } from '@inertiajs/react';
import { Button, Modal, PasswordInput } from '@mantine/core';
import { useDisclosure } from '@mantine/hooks';
import { notifications } from '@mantine/notifications';
import React from 'react';

function EnableTowFactor() {
    const [opened, { open: openModal, close: closeModal }] =
        useDisclosure(false);
    const [loading, { open: openLoading, close: closeLoading }] =
        useDisclosure();

    const { data, setData, put, errors } = useForm({
        current_password: '',
    });

    const handleActivateTwoFactor = (e: React.FormEvent) => {
        e.preventDefault();
        openLoading();

        put(route('enable.fortify'), {
            preserveScroll: true,
            onSuccess: () => {
                notifications.show({
                    title: 'Success',
                    message: '2FA has been enabled.',
                    color: 'green',
                });
                closeModal();
                closeLoading();
            },
            onError: () => {},
            onFinish: () => {
                closeLoading();
            },
        });
    };

    return (
        <div className="mt-2 flex w-96 items-center justify-center gap-4">
            <Button
                fullWidth
                onClick={openModal}
                type="button"
                variant="filled"
                color="rgba(0, 0, 0, 1)"
            >
                Active 2FA
            </Button>
            <Modal opened={opened} onClose={closeModal} title="Authentication">
                <div className="px-4">
                    <form onSubmit={handleActivateTwoFactor}>
                        <PasswordInput
                            mt="xl"
                            label="Password"
                            placeholder="Password"
                            error={errors.current_password}
                            withAsterisk
                            inputWrapperOrder={['label', 'input', 'error']}
                            name="current_password"
                            value={data.current_password}
                            onChange={(e) =>
                                setData('current_password', e.target.value)
                            }
                            autoFocus={true}
                        />

                        <div className="my-4 flex items-center gap-4">
                            <Button
                                type="submit"
                                fullWidth
                                variant="filled"
                                color="rgba(0, 0, 0, 1)"
                                loading={loading}
                                loaderProps={{ type: 'dots' }}
                            >
                                Active 2FA
                            </Button>
                        </div>
                    </form>
                </div>
            </Modal>
        </div>
    );
}

export default EnableTowFactor;
