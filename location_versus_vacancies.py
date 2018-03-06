import matplotlib.pyplot as plt

labels = ["Beijing", "Shanghai", "Chengdu", "Guangzhou"]
values = [392, 363, 243, 242]
colors = ["yellow", "green", "red", "blue"]
explode = [0.1, 0, 0, 0]
plt.title("location versus vacancies")
plt.pie(values, labels=labels, colors=colors, explode=explode, shadow=True, autopct='%1.1f%%', startangle=180)
plt.axis('equal')
plt.show()
