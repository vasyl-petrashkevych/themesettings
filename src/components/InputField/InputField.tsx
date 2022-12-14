import {FC} from 'react';
import {IField, ISelect} from "../../types";
import {Input, Form} from "antd";
import {FieldTitle, FieldWrapper} from '../index'
type Props = {
    fieldData: IField,
    tab: string
}
export const InputField: FC<Props> = ({fieldData, tab}) => {
    const {slug, title, hint, required, value} = fieldData;
    return <FieldWrapper>
        <Form.Item
            name={`${tab}_${slug}`}
            label={<FieldTitle title={title} hint={hint}/>}
            initialValue={value}
            rules={[{required, message: 'This field is required'}]}
        >
            <Input/>
        </Form.Item>
    </FieldWrapper>
}