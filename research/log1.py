#!/usr/bin/python
print("-----------------------------------")
print("Start of Tests")
print("-----------------------------------")
# Variables
print("Variables:")
var1, var2 = 5, 10
print(var1 + var2)
str1 = "Group 11"
str2 = " is awesome"
print(str1 + str2)

# Control Flow
x = 5
if x < 0:
    print("number is negative")
elif x == 0:
    print("number is 0")
elif x > 0:
    print("number is positive")
words = ["cat", "dog", "cow", "elephant"]
for word in words:
    print word, len(word)
print(range(10))
print(range(5, 10))
print(range(0, 10, 3))
print(range(-10, -100, -30))

# Lists
print("Lists:")
list = [1, 2, 3, 4, 5]
print(list, len(list))
list.append(6)
print(list, len(list))
list[1:5] = ["Two", "Three", "Four", "Five"]
print(list, len(list))
list[1:5] = []
print(list, len(list))
list1 = [1, 2, 3, 4]
list2 = ["a", "b", "c", "d"]
list3 = [list1, list2]
print(list3, len(list3))


